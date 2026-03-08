<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'listing_id',
        'type',
        'reading_start',
        'reading_end',
        'price_per_unit',
        'amount',
        'due_date',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'reading_start' => 'decimal:2',
            'reading_end' => 'decimal:2',
            'price_per_unit' => 'decimal:2',
            'amount' => 'decimal:2',
            'due_date' => 'date',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public static function types(): array
    {
        return [
            'water' => 'Water',
            'electricity' => 'Electricity',
            'internet' => 'Internet',
            'rent' => 'Rent',
            'other' => 'Other',
        ];
    }

    public static function statuses(): array
    {
        return [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'overdue' => 'Overdue',
        ];
    }

    public function isOverdue(): bool
    {
        return $this->status === 'overdue' || ($this->status === 'pending' && $this->due_date->isPast());
    }
}
