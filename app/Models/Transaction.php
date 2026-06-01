<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'ticket_id',
        'qty',
        'total_price',
        'booking_date',
        'status',
        'payment_expires_at',
        'last_midtrans_order_id',
        'snap_token',
        'qr_code_token',
        'rating',
        'review_comment',
        'review_image',
    ];

    public static function usesMinuteTimeout(): bool
    {
        $minutes = config('checkout.payment_timeout_minutes');

        return $minutes !== null && $minutes !== '';
    }

    public static function paymentTimeoutHours(): int
    {
        return max(1, (int) config('checkout.payment_timeout_hours', 6));
    }

    public static function paymentTimeoutMinutes(): int
    {
        return max(1, (int) config('checkout.payment_timeout_minutes', 1));
    }

    public static function paymentExpiresAfter(Carbon $from): Carbon
    {
        if (self::usesMinuteTimeout()) {
            return $from->copy()->addMinutes(self::paymentTimeoutMinutes());
        }

        return $from->copy()->addHours(self::paymentTimeoutHours());
    }

    public static function paymentTimeoutCutoff(): Carbon
    {
        if (self::usesMinuteTimeout()) {
            return now()->subMinutes(self::paymentTimeoutMinutes());
        }

        return now()->subHours(self::paymentTimeoutHours());
    }

    /** @return array{unit: string, duration: int} */
    public static function midtransExpiryConfig(): array
    {
        if (self::usesMinuteTimeout()) {
            return [
                'unit' => 'minute',
                'duration' => self::paymentTimeoutMinutes(),
            ];
        }

        return [
            'unit' => 'hour',
            'duration' => self::paymentTimeoutHours(),
        ];
    }

    public static function paymentTimeoutLabel(): string
    {
        if (self::usesMinuteTimeout()) {
            $minutes = self::paymentTimeoutMinutes();

            return $minutes === 1 ? '1 menit' : "{$minutes} menit";
        }

        $hours = self::paymentTimeoutHours();

        return $hours === 1 ? '1 jam' : "{$hours} jam";
    }

    public function paymentExpiresAt(): Carbon
    {
        return self::paymentExpiresAfter($this->created_at);
    }

    /** Sinkronkan kolom DB dengan konfigurasi timeout saat ini (penting saat ganti .env untuk testing). */
    public function refreshPaymentExpiresAt(): void
    {
        if ($this->status !== 'pending') {
            return;
        }

        $expiresAt = self::paymentExpiresAfter($this->created_at);
        if (!$this->payment_expires_at || !$this->payment_expires_at->equalTo($expiresAt)) {
            $this->update(['payment_expires_at' => $expiresAt]);
        }
    }

    public function isPaymentWindowExpired(): bool
    {
        return $this->status === 'pending' && now()->gte($this->paymentExpiresAt());
    }

    public function expireUnpaidPayment(): bool
    {
        return app(\App\Services\TransactionPaymentService::class)
            ->expirePendingPayment($this->fresh());
    }

    /** QR gerbang masuk hanya diterbitkan setelah pembayaran sukses. */
    public function issueEntryQrToken(): string
    {
        if ($this->qr_code_token) {
            return $this->qr_code_token;
        }

        $token = (string) str()->uuid();
        $this->update(['qr_code_token' => $token]);

        return $token;
    }

    public function hasActiveEntryQr(): bool
    {
        return $this->status === 'settlement'
            && ! empty($this->qr_code_token)
            && ! $this->is_expired;
    }

    public function getReviewImageUrlAttribute(): ?string
    {
        return $this->review_image ? asset('storage/' . $this->review_image) : null;
    }

    public function getIsExpiredAttribute(): bool
    {
        return in_array($this->status, ['pending', 'settlement'])
            && $this->booking_date
            && $this->booking_date->isPast()
            && !$this->booking_date->isToday();
    }

    public function getDisplayStatusAttribute(): string
    {
        if ($this->is_expired) {
            return 'expire';
        }
        return $this->status;
    }

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'payment_expires_at' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
