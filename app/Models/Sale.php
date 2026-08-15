<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'clientCode',
        'clientName',
        'customer_id',
        'serviceType',
        'requestType',
        'changeReason',
        'planFrom',
        'totalFrom',
        'notes',
        'total',
        'plan_id',
        'createdBy_id',
        'lastEditedBy_id',
        'lastEditedAt',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'totalFrom' => 'decimal:2',
            'total' => 'decimal:2',
            'lastEditedAt' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'createdBy_id');
    }

    public function lastEditedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lastEditedBy_id');
    }
}
