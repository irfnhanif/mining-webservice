<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $fillable = [
        'name', 'type', 'status', 'location'
    ];

    protected $table = 'equipments';
    public $timestamps = false;

    public function maintenances(): HasMany 
    {
        return $this->hasMany(Maintenance::class);
    }

    public function sensors(): HasMany
    {
        return $this->hasMany(Sensor::class);
    }
}
