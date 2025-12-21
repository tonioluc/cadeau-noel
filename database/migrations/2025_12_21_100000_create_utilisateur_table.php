<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->increments('id_utilisateur');
            $table->string('nom', 100);
            $table->string('mot_de_passe', 255);
            $table->decimal('solde', 10, 2)->default(0);
            $table->dateTime('date_creation')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateur');
    }
};
