<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outflow extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'personName',
        'amount',
        'concept',
        'createdBy_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Outflow $outflow) {
            if (is_null($outflow->created_at)) {
                $outflow->created_at = now();
            }
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'createdBy_id');
    }
}
