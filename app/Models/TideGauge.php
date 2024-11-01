<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tide_gauge_user');
    }
}
