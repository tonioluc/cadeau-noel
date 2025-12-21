<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commission_site', function (Blueprint $table) {
            $table->increments('id_commission');
            $table->unsignedInteger('id_depot');
            $table->decimal('montant_commission', 10, 2);
            $table->dateTime('date_commission')->useCurrent();
            $table->unique('id_depot');

            $table->foreign('id_depot')->references('id_depot')->on('depot')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('commission_site', function (Blueprint $table) {
            $table->dropForeign(['id_depot']);
            $table->dropUnique(['id_depot']);
        });
        Schema::dropIfExists('commission_site');
    }
};
