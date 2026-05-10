<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const TYPE_ADMIN = 1;
    public const TYPE_USER = 2;
    public const TYPE_OWNER = 3;
    public const TYPE_EMPLOYEE = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'google_id',
        'tipe_user',
        'owner_id',
        'balance',
        'bank_code',
        'bank_account_number',
        'bank_account_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    /** Karyawan yang dimiliki oleh owner ini */
    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    /** Owner dari karyawan ini */
    public function ownerUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /** Helper: dapatkan ID owner yg sesungguhnya (owner sendiri atau owner dari karyawan) */
    public function resolveOwnerId(): int
    {
        return $this->tipe_user === self::TYPE_EMPLOYEE ? $this->owner_id : $this->id;
    }
}
