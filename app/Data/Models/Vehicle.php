<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'car_pic',
        'car_make',
        'car_model',
        'car_number',
        'car_year'
    ];
}
