<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'description',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public static function types(): array
    {
        return ['room' => 'Room', 'house' => 'House', 'apartment' => 'Apartment'];
    }

    public static function statuses(): array
    {
        return [
            'occupied' => 'Occupied',
            'renovation' => 'Renovation',
            'available' => 'Available',
        ];
    }
}
