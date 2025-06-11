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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number')->unique()->comment('Numéro de facture (numfact)');
            $table->date('sale_date')->comment('Date de la facture (date)');
            $table->decimal('total_amount', 10, 2)->comment('Montant TTC (mtttc)');
            $table->string('image_path')->nullable()->comment('Chemin de l’image de la facture');

            $table->string('accord_reference')->nullable()->comment('Accord / Contrat (accord)');
            $table->string('purchase_order_number')->nullable()->comment('Bon de commande (bc)');
            $table->string('delivery_note_number')->nullable()->comment('Bon de livraison (bl)');
            $table->string('payment_order_reference')->nullable()->comment('Ordre de règlement (or)');
            $table->enum('statut_facture', [
            'creation',
            'facturé',
            'envoyée_pour_paiement',
            'paiement'
        ])->default('creation')->comment('statut_facture');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade')->comment('Client');
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade')->comment('Véhicule');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->comment('Utilisateur qui a créé la facture');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Utilisateur qui a enregistré le client');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
