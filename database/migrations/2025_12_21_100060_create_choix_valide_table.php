<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('choix_valide', function (Blueprint $table) {
            $table->increments('id_choix');
            $table->unsignedInteger('id_utilisateur');
            $table->decimal('montant_total', 10, 2);
            $table->integer('nbr_fille');
            $table->integer('nbr_garcon');
            $table->dateTime('date_choix')->useCurrent();

            $table->foreign('id_utilisateur')->references('id_utilisateur')->on('utilisateur')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('choix_valide', function (Blueprint $table) {
            $table->dropForeign(['id_utilisateur']);
        });
        Schema::dropIfExists('choix_valide');
    }
};
