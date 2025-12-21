<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historique_statut_depot', function (Blueprint $table) {
            $table->increments('id_historique');
            $table->unsignedInteger('id_depot');
            $table->unsignedInteger('id_statut_depot');
            $table->dateTime('date_changement')->useCurrent();

            $table->foreign('id_depot')->references('id_depot')->on('depot')->onDelete('cascade');
            $table->foreign('id_statut_depot')->references('id_statut_depot')->on('statut_depot');
        });
    }

    public function down(): void
    {
        Schema::table('historique_statut_depot', function (Blueprint $table) {
            $table->dropForeign(['id_depot']);
            $table->dropForeign(['id_statut_depot']);
        });
        Schema::dropIfExists('historique_statut_depot');
    }
};
