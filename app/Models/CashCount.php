<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashCount extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'coin_050',
        'coin_1',
        'coin_2',
        'coin_5',
        'bill_10',
        'bill_20',
        'bill_50',
        'bill_100',
        'bill_200',
        'createdBy_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'coin_050' => 'integer',
            'coin_1' => 'integer',
            'coin_2' => 'integer',
            'coin_5' => 'integer',
            'bill_10' => 'integer',
            'bill_20' => 'integer',
            'bill_50' => 'integer',
            'bill_100' => 'integer',
            'bill_200' => 'integer',
            'updated_at' => 'datetime',
        ];
    }

    public function getTotalAttribute(): float
    {
        return round(
            ($this->coin_050 * 0.50) +
            ($this->coin_1 * 1) +
            ($this->coin_2 * 2) +
            ($this->coin_5 * 5) +
            ($this->bill_10 * 10) +
            ($this->bill_20 * 20) +
            ($this->bill_50 * 50) +
            ($this->bill_100 * 100) +
            ($this->bill_200 * 200),
            2
        );
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'createdBy_id');
    }

    public function outflows(): HasMany
    {
        return $this->hasMany(Outflow::class, 'date', 'date');
    }
}
