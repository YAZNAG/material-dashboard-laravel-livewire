<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
            Schema::create('visites', function (Blueprint $table) {
                $table->id();
                $table->date('date_debut');
                $table->date('date_fin');
                $table->string('type');
                $table->string('numero_autorisation')->nullable();
                $table->string('nom_centre')->nullable();
                $table->string('address_centre')->nullable();
                $table->string('resultat')->nullable();
                $table->string('visite_image')->nullable();
                $table->foreignId('camion_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
