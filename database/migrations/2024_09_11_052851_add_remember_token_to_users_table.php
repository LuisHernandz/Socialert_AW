<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'remember_token')) {
            $table->rememberToken(); // Solo agrega la columna si no existe
        }
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (Schema::hasColumn('users', 'remember_token')) {
            $table->dropColumn('remember_token'); // Elimina la columna si existe
        }
    });
}


};
