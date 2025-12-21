<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historique_parametres', function (Blueprint $table) {
            $table->increments('id_historique_parametre');
            $table->unsignedInteger('id_parametre');
            $table->string('ancienne_valeur', 255);
            $table->string('nouvelle_valeur', 255);
            $table->dateTime('date_modification')->useCurrent();

            $table->foreign('id_parametre')->references('id_parametre')->on('parametres')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('historique_parametres', function (Blueprint $table) {
            $table->dropForeign(['id_parametre']);
        });
        Schema::dropIfExists('historique_parametres');
    }
};
