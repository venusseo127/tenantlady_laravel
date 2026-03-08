<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'plan',
        'referral_code',
        'firebase_uid',
        'fcm_token',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'user_id');
    }

    public function tenantRecords()
    {
        return $this->hasMany(Tenant::class, 'account_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function referralsMade()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referralsReceived()
    {
        return $this->hasMany(Referral::class, 'referred_user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLandlord(): bool
    {
        return in_array($this->role, ['landlord', 'admin', 'hybrid']);
    }

    public function isTenant(): bool
    {
        return in_array($this->role, ['tenant', 'hybrid']);
    }

    public function isHybrid(): bool
    {
        return $this->role === 'hybrid';
    }

    public function listingLimit(): int
    {
        $plans = Subscription::plans();
        $limit = $plans[$this->plan]['listings'] ?? 1;
        return $limit === -1 ? PHP_INT_MAX : $limit;
    }

    public function canAddListing(): bool
    {
        return $this->listings()->count() < $this->listingLimit();
    }
}
