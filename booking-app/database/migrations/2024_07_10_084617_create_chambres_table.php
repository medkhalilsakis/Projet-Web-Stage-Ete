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
        Schema::create('chambres', function (Blueprint $table) {
            $table->string('num_chambre')->primary(); 
            $table->string('code_hb'); 
            $table->boolean('disponibilite'); 
            $table->double('prix_par_nuit', 8, 2); 
            $table->integer('nb_personnes_max');
            $table->text('description')->nullable();
            $table->foreign('code_hb')
                  ->references('code_hb')
                  ->on('hebergements')
                  ->onDelete('cascade'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};
