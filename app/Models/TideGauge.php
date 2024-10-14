<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TideGauge extends Model
{
    use HasFactory;

    protected $table = 'tidegauges';
    protected $fillable = [
        '_serial',
        '_country',
        '_loc',
        '_lat',
        '_lon',
        '_date',
        '_time',
        '_tide',
        '_units',
    ];
}
