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
            Schema::create('taxe_speciale_annuelle', function (Blueprint $table) {
                $table->id();
                $table->year('annee');
                $table->string('trache');
                $table->decimal('montant_principal', 10, 2);
                $table->decimal('penalite', 10, 2)->nullable();
                $table->decimal('majorations', 10, 2)->nullable();
                $table->decimal('montant_total', 10, 2);
                $table->date('date_paiement')->nullable();
                $table->foreignId('camion_id')->constrained()->onDelete('cascade');
                $table->string('taxe_image')->nullable();
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxe_speciale_annuelle');
    }
};
