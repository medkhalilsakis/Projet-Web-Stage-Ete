<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Store the unique filename
            $table->string('path'); // Store the relative path within the storage directory
            $table->string('mime_type'); // Store the MIME type for validation and display
            $table->unsignedBigInteger('size')->nullable(); // Store the file size for potential filtering
            $table->string('code_hb')->nullable(); // Foreign key to the hebergements table
            $table->string('num_chambre')->nullable(); // Foreign key to the chambres table
            $table->timestamps();

            // Adding foreign keys constraints
            $table->foreign('code_hb')->references('code_hb')->on('hebergements')->onDelete('cascade');
            $table->foreign('num_chambre')->references('num_chambre')->on('chambres')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
