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
        Schema::table('donations', function (Blueprint $table) {
            $table->enum('donation_type', ['goods', 'money'])->default('goods')->after('status');
            $table->decimal('amount', 12, 2)->nullable()->after('donation_type');
            $table->enum('payment_method', ['bank_transfer', 'e_wallet', 'cash'])->nullable()->after('amount');
            $table->boolean('is_anonymous')->default(false)->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['donation_type', 'amount', 'payment_method', 'is_anonymous']);
        });
    }
};
