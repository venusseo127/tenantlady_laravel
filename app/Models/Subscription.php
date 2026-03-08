<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan',
        'payment_provider',
        'renewal_date',
        'status',
        'provider_subscription_id',
    ];

    protected function casts(): array
    {
        return [
            'renewal_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function plans(): array
    {
        return [
            'free' => ['listings' => 1, 'price' => 0, 'label' => 'Free'],
            'starter' => ['listings' => 4, 'price' => 199, 'label' => 'Starter (₱199/mo)'],
            'pro' => ['listings' => -1, 'price' => 499, 'label' => 'Pro (₱499/mo)'],
            'business' => ['listings' => -1, 'price' => 999, 'label' => 'Business (₱999/mo)'],
        ];
    }
}
