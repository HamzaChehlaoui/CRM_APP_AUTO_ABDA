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
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('full_name')->comment('Nom complet');
        $table->string('phone')->comment('Téléphone');
        $table->string('cin')->comment('Carte d\'identité nationale');
        $table->string('address')->nullable()->comment('Adresse');
        $table->string('email')->nullable()->comment('Email');
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
        Schema::dropIfExists('clients');
    }
};
