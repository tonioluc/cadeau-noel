<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cadeau', function (Blueprint $table) {
            $table->increments('id_cadeau');
            $table->string('nom', 100);
            $table->text('description')->nullable();
            $table->unsignedInteger('id_categorie_cadeau');
            $table->decimal('prix', 10, 2);
            $table->string('chemin_image', 255)->nullable();
            $table->dateTime('date_ajout')->useCurrent();

            $table->foreign('id_categorie_cadeau')->references('id_categorie_cadeau')->on('categorie_cadeau');
        });
    }

    public function down(): void
    {
        Schema::table('cadeau', function (Blueprint $table) {
            $table->dropForeign(['id_categorie_cadeau']);
        });
        Schema::dropIfExists('cadeau');
    }
};
