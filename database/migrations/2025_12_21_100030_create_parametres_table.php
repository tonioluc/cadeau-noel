<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->increments('id_parametre');
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->string('valeur', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametres');
    }
};
