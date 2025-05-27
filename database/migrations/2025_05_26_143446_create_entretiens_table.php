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
        Schema::create('entretiens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('set null');
        $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        $table->string('type');
        $table->date('scheduled_at');
        $table->text('description')->nullable();
         $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade')->comment('Agence / Succursale');
        $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Utilisateur qui a enregistré le client');

        $table->enum('status', ['planifié', 'réalisé', 'annulé'])->default('planifié');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entretiens');
    }
};
