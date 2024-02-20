<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingFacilityDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        "booking_date" => "date",
        "return_date" => "date",
    ];

    public function bookingFacility(): BelongsTo
    {
        return $this->belongsTo(BookingFacility::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}
