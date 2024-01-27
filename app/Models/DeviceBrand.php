<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceBrand extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(deviceType::class);
    }

    public function deviceSeries(): HasMany
    {
        return $this->hasMany(DeviceSeries::class);
    }
}
