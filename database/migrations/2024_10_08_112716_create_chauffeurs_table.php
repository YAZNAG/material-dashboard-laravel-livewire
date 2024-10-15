<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChauffeursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chauffeurs', function (Blueprint $table) {
            $table->id(); // colonne id
            $table->string('nom'); // colonne nom
            $table->string('prenom'); // colonne prenom
            $table->string('cin'); // colonne cin
            $table->string('cin_image')->nullable(); // colonne cin_image (chemin du fichier)
            $table->string('certificat_medical_image')->nullable(); // colonne certificat médical (chemin du fichier)
            $table->string('permis_image')->nullable(); // colonne permis_image (chemin du fichier)
            $table->string('type_permis'); // colonne type de permis
            $table->date('date_naissance'); // colonne date de naissance
            $table->string('telephone'); // colonne téléphone
            $table->string('adresse'); // colonne adresse
            $table->timestamps(); // colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chauffeurs');
    }
}
