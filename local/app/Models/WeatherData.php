<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $table = 'weather_data';
    protected $fillable = [
        'serial',
        'time',
        'wind_direction',
        'wind_speed',
        'temperature',
        'humidity',
        'pressure',
    ];
}
