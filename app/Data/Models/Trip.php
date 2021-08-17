<?php

namespace App\Data\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Trip extends Model
{
    protected $fillable = [
        'trip_type_id', 'vehicle_id', 'driver_rating', 'driver_id', 'request_date', 'pickup_lat', 'pickup_lng', 'pickup_location', 'pickup_date', 'dropoff_lat', 'dropoff_lng', 'dropoff_location', 'dropoff_date', 'status'
    ];

    public function getRequestDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->toDayDateTimeString();
        }
    }

    public function scopeFilter($query, Request $request)
    {
        $query
            ->when($request->include_cancelled_trips == true,function ($q) use ($request){
                $q->whereIn('status',['COMPLETED','CANCELED']);
            })
            ->when($request->include_cancelled_trips == false,function ($q) use ($request){
                $q->whereIn('status',['COMPLETED']);
            })
            ->when(isset($request->distance) && count($request->distance) > 1,function ($q) use ($request){
                $q->whereHas('trip_detail',function ($q) use ($request){
                    $q->where('distance','>=',$request->distance[0])
                        ->where('distance','<=',$request->distance[1]);
                });
            })
            ->when(isset($request->distance) && count($request->distance) === 1,function ($q) use ($request){
                $q->whereHas('trip_detail',function ($q) use ($request){
                    $q->where('distance','>',$request->distance[0]);
                });
            })
            ->when(isset($request->time) && count($request->time) > 1,function ($q) use ($request){
                $q->whereHas('trip_detail',function ($q) use ($request){
                    $q->where('duration','>=',$request->time[0])
                        ->where('duration','<=',$request->time[1]);
                });
            })
            ->when(isset($request->time) && count($request->time) === 1,function ($q) use ($request){
                $q->whereHas('trip_detail',function ($q) use ($request){
                    $q->where('duration','>',$request->time[0]);
                });
            })
            ->when(isset($request->search), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->whereHas('driver', function ($q) use ($request) {
                        $q->where('driver_name', 'like', '%' . $request->search . '%');
                    })->orWhereHas('vehicle', function ($q) use ($request) {
                        $q->where('car_make', 'like', '%' . $request->search . '%')
                            ->orWhere('car_model', 'like', '%' . $request->search . '%')
                            ->orWhere('car_number', 'like', '%' . $request->search . '%');
                    })->orWhereHas('type', function ($q) use ($request) {
                        $q->where('type', 'like', '%' . $request->search . '%');
                    })->orWhere('pickup_location', 'like', '%' . $request->search . '%')
                        ->orWhere('dropoff_location', 'like', '%' . $request->search . '%');
                });
            });

    }

    public function type()
    {
        return $this->belongsTo(TripType::class, 'trip_type_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function trip_detail()
    {
        return $this->hasOne(TripDetail::class);
    }
}
