<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function facilityType(): BelongsTo
    {
        return $this->belongsTo(FacilityType::class);
    }

    public function bookingFacilityDetails(): HasMany
    {
        return $this->hasMany(BookingFacilityDetail::class);
    }
}
