<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class DriverVehicle extends Model
{
    protected $fillable = [
        'driver_id', 'vehicle_id'
    ];
}
