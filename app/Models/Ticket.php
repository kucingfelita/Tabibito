<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'destination_id',
        'name',
        'price',
        'benefit',
        'daily_quota',
        'current_quota',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getAvailableQuota(string $date): int
    {
        $soldQty = $this->transactions()
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'settlement', 'used'])
            ->sum('qty');

        return max(0, $this->daily_quota - $soldQty);
    }
}
