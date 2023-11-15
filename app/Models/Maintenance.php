<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Maintenance extends Model
{
    protected $fillable = [
        'datetime', 'duration', 'cost', 'location', 'equipment_id'
    ];

    protected $table = 'maintenances';
    public $timestamps = false;

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
