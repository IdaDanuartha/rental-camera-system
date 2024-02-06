<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();            
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->smallInteger('role')->comment('[0: Admin, 1: Staff, 2: Customer]')->default(2);
            $table->boolean('status')->default(1);
            $table->morphs('authenticatable');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
