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
        Schema::create('hebergements', function (Blueprint $table) {
            $table->string('code_hb')->primary(); 
            $table->string('nom');
            $table->enum('type', ['hotel', 'maison', 'appartement', 'villa']);
            $table->string('adresse');
            $table->integer('nbr_de_chambres');
            $table->text('description')->nullable();
            $table->text('pts_forts')->nullable();
            $table->string('num_tel');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hebergements');
    }
};
