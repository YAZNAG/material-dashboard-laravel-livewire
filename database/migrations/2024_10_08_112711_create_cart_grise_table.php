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
            Schema::create('cart_grise', function (Blueprint $table) {
                $table->id();
                $table->foreignId('camion_id')->constrained()->onDelete('cascade');
                $table->string('image_path');
                $table->date('date_fin');
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_grise');
    }
};
