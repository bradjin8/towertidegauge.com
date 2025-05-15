<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weathers';
    protected $fillable = [
        'header',
        '_date',
        '_time',
        'barometric_pressure_inches',
        'barometric_pressure_mm',
        'air_temperature',
        'water_temperature',
        'relative_humidity',
        'absolute_humidity',
        'dew_point',
        'wind_direction_true',
        'wind_direction_mg',
        'wind_speed_kts',
        'wind_speed_mps',
    ];

    public function tideGauge(): BelongsTo
    {
        return $this->belongsTo(TideGauge::class, 'tidegauge_id');
    }
}
