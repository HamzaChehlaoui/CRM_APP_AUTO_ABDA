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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->comment('Marque');
            $table->string('model')->comment('Modèle');
            $table->string('ivn')->unique()->comment('Identifiant Véhicule Neuf (ivn)');
            $table->string('registration_number')->unique()->comment('Numéro d’immatriculation (matricul)');
            $table->string('chassis_number')->unique()->comment('Numéro de châssis (VIN)');
            $table->string('color')->nullable()->comment('Couleur');
            $table->year('year')->nullable()->comment('Année de fabrication');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade')->comment('Agence / Succursale');
        $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Utilisateur qui a enregistré le client');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
