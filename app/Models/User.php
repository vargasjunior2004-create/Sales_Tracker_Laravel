<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    public function salesCreated(): HasMany
    {
        return $this->hasMany(Sale::class, 'createdBy_id');
    }

    public function salesEdited(): HasMany
    {
        return $this->hasMany(Sale::class, 'lastEditedBy_id');
    }

    public function cashCounts(): HasMany
    {
        return $this->hasMany(CashCount::class, 'createdBy_id');
    }

    public function outflows(): HasMany
    {
        return $this->hasMany(Outflow::class, 'createdBy_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
