<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'label',
        'type',
        'speed',
        'monthly',
        'installation',
        'active',
        'legacy',
    ];

    protected function casts(): array
    {
        return [
            'speed' => 'integer',
            'monthly' => 'decimal:2',
            'installation' => 'decimal:2',
            'active' => 'boolean',
            'legacy' => 'boolean',
        ];
    }

    public function getTotalAttribute(): string
    {
        return number_format((float) $this->monthly + (float) $this->installation, 2, '.', '');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
