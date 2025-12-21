<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('depot', function (Blueprint $table) {
            $table->increments('id_depot');
            $table->unsignedInteger('id_utilisateur');
            $table->decimal('montant_demande', 10, 2);
            $table->decimal('montant_credit', 10, 2);
            $table->decimal('commission_applique', 5, 2);
            $table->unsignedInteger('id_statut_depot');

            $table->foreign('id_utilisateur')->references('id_utilisateur')->on('utilisateur')->onDelete('cascade');
            $table->foreign('id_statut_depot')->references('id_statut_depot')->on('statut_depot');
        });
    }

    public function down(): void
    {
        Schema::table('depot', function (Blueprint $table) {
            $table->dropForeign(['id_utilisateur']);
            $table->dropForeign(['id_statut_depot']);
        });
        Schema::dropIfExists('depot');
    }
};
