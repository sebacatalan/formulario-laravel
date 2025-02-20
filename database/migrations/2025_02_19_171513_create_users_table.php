<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Clave primaria (bigIncrements)
            $table->string('nombre');
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            // $table->softDeletes(); // (Opcional) Permite "eliminaciones suaves"
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
