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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->text('description', 100)->nullable();
            $table->string('file', 255)->nullable();
            $table->integer('calification')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('citizen_id')->nullable();

            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('citizen_id')->references('id')->on('citizens')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
