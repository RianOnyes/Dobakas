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
        // Drop the existing table if it exists
        Schema::dropIfExists('donation_requests');
        
        // Recreate the table with the correct structure
        Schema::create('donation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->enum('urgency_level', ['low', 'medium', 'high'])->default('medium');
            $table->integer('quantity_needed')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'fulfilled', 'cancelled'])->default('active');
            $table->date('needed_by')->nullable();
            $table->json('tags')->nullable(); // Additional tags/keywords
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_requests');
    }
};
