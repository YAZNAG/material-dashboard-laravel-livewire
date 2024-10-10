<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamionsTable extends Migration
{
    public function up()
    {
        Schema::create('camions', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 191)->unique();
            $table->string('antérieure_matricule',100)->unique();
            $table->string('camion_title');
            $table->text('modele')->nullable();
            $table->text('type')->nullable();
            $table->date('date_imma');
            $table->date('date_mec')->nullable();
            $table->string('genre')->nullable();
            $table->string('marque')->nullable();
            $table->string('type_carburant')->nullable();
            $table->string('numero_chassais')->nullable();
            $table->integer('nombre_cylindres')->nullable();
            $table->float('ptmct')->nullable();
            $table->string('type_usage')->nullable();
            $table->float('poids_vide')->nullable();
            $table->float('puissance_fiscale')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('camions');
    }
}
