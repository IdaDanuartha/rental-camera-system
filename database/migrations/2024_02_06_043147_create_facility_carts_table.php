<?php

use App\Models\Facility;
use App\Models\User;
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
        Schema::create('facility_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreignIdFor(Facility::class)
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->integer('qty')->default(1);
            $table->date('booking_date')->default(now());
            $table->date('return_date')->default(now()->addDay(1));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_carts');
    }
};
