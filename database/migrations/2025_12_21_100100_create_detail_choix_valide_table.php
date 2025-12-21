<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_choix_valide', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_choix');
            $table->unsignedInteger('id_cadeau');
            $table->enum('type_enfant', ['FILLE', 'GARÇON', 'NEUTRE']);
            $table->integer('numero_enfant');

            $table->unique(['id_choix', 'type_enfant', 'numero_enfant']);
            $table->unique(['id_choix', 'id_cadeau']);

            $table->foreign('id_choix')->references('id_choix')->on('choix_valide')->onDelete('cascade');
            $table->foreign('id_cadeau')->references('id_cadeau')->on('cadeau');
        });
    }

    public function down(): void
    {
        Schema::table('detail_choix_valide', function (Blueprint $table) {
            $table->dropForeign(['id_choix']);
            $table->dropForeign(['id_cadeau']);
            $table->dropUnique('detail_choix_valide_id_choix_type_enfant_numero_enfant_unique');
            $table->dropUnique('detail_choix_valide_id_choix_id_cadeau_unique');
        });
        Schema::dropIfExists('detail_choix_valide');
    }
};
