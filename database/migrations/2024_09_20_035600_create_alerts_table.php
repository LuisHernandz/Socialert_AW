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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('reports_id')->nullable();
            $table->unsignedBigInteger('citizen_id')->nullable();

            $table->foreign('reports_id')->references('id')->on('reports')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('citizen_id')->references('id')->on('citizens')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
