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
            $table->string('brand')->nullable()->comment('Marque');
            $table->string('model')->nullable()->comment('Modèle');
            $table->string('ivn')->nullable()->unique()->comment('Identifiant Véhicule Neuf (ivn)');
            $table->string('registration_number')->nullable()->unique()->comment('Numéro d’immatriculation (matricul)');
            $table->string('chassis_number')->nullable()->unique()->comment('Numéro de châssis (VIN)');
            $table->string('color')->nullable()->comment('Couleur');
            $table->year('year')->nullable()->comment('Année de fabrication');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('cascade')->comment('Agence / Succursale');
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
