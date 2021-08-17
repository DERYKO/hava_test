<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class TripDetail extends Model
{
    protected $fillable = [
        'trip_id', 'duration', 'duration_unit', 'distance', 'distance_unit', 'cost', 'cost_unit'
    ];
}
