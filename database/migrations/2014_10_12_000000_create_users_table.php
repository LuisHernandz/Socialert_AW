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
            $table->string('name', 45);
            $table->string('lastname', 45);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->enum('estado', ['active', 'inactive'])->nullable();
            $table->timestamps();
        });

                    // $table->timestamp('email_verified_at')->nullable();
            // $table->rememberToken();
            // $table->foreignId('current_team_id')->nullable();
            // $table->string('profile_photo_path', 2048)->nullable();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
