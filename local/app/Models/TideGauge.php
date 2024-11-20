<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tide_gauge_user');
    }

    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class, 'tidegauge_id');
    }
}
