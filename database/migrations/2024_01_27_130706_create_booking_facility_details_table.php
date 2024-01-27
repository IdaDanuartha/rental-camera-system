<?php

use App\Models\BookingFacility;
use App\Models\Facility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_facility_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BookingFacility::class)
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignIdFor(Facility::class)
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->integer('quantity');
            $table->integer('rental_price');
            $table->dateTime('booking_date');
            $table->dateTime('return_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_facility_details');
    }
};
