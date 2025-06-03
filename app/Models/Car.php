<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
    'brand',
    'model',
    'ivn',
    'registration_number',
    'chassis_number',
    'color',
    'year',
    'client_id',
    'branch_id',
    'created_by',
];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function entretiens(): HasMany
    {
        return $this->hasMany(Entretien::class);
    }
}
