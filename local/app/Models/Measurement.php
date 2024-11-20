<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Measurement extends Model
{
    use HasFactory;

    protected $table = 'measurements';
    protected $fillable = [
        '_date',
        '_time',
        '_tide',
        '_units',
    ];

    public function tideGauge(): BelongsTo
    {
        return $this->belongsTo(TideGauge::class, 'tidegauge_id');
    }
}
