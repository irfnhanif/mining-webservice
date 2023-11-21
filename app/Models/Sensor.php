<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sensor extends Model
{
    protected $fillable = [
        'name', 'type', 'equipment_id'
    ];

    public $timestamps = false;

    protected $table = 'sensors';

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
