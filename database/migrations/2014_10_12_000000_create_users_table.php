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
            $table->string('image')->nullable();
            $table->string('first_name', 150);
            $table->string('phone_number', 15);
            $table->string('last_name', 150)->nullable();
            $table->string('username', 150)->nullable();
            $table->string('email', 150)->unique();
            $table->string('user_type', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 150)->nullable();
            $table->string('role', 150)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
