<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_resv');
            $table->string('client');
            $table->date('date_arr');
            $table->date('date_dep');
            $table->integer('nbr_adultes'); 
            $table->integer('nbr_enfants');
            $table->integer('nbr_chambres');
            $table->string('code_hb');
            $table->string('num_chambre');
            $table->double('prix_total', 8, 2);
            $table->timestamps();

           
            $table->foreign('code_hb')
                  ->references('code_hb')
                  ->on('hebergements')
                  ->onDelete('cascade');
            $table->foreign('num_chambre')
                  ->references('num_chambre')
                  ->on('chambres')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
