<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = [
        'name', 'type', 'equipment_id'
    ];

    public $timestamps = false;

    protected $table = 'sensors';

}
