<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

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
        'snap_token',
        'qr_code_token',
        'rating',
        'review_comment',
        'review_image',
    ];

    public function getReviewImageUrlAttribute(): ?string
    {
        return $this->review_image ? asset('storage/' . $this->review_image) : null;
    }

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
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
