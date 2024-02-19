<?php

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
        Schema::create('booking_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->string('code');
            $table->integer('total_price');
            $table->integer('total_payment');
            $table->integer('total_return');
            $table->smallInteger('status')->default(1)->comment("[1: Rented, 2: Returned]");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_facilities');
    }
};
