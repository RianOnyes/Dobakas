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
        Schema::create('organization_details', function (Blueprint $table) {
            $table->id();

            // Kunci asing ke tabel users (organisasi). `unique()` karena 1 akun user organisasi = 1 detail organisasi.
            // Jika akun user organisasi dihapus, detail organisasinya juga terhapus.
            $table->foreignId('user_id')->constrained('users')->unique()->onDelete('cascade');

            $table->string('organization_name'); // Nama resmi organisasi/panti asuhan
            $table->string('contact_person')->nullable(); // Nama kontak Person In Charge (PIC) (boleh kosong)
            $table->string('contact_phone')->nullable(); // Nomor telepon kontak organisasi (boleh kosong)
            $table->string('organization_address')->nullable(); // Alamat lengkap organisasi (boleh kosong)
            $table->text('description')->nullable(); // Deskripsi singkat tentang organisasi (boleh kosong)
            $table->json('needs_list')->nullable(); // Daftar kebutuhan spesifik yang sering dicari (dalam format JSON array, boleh kosong)
            $table->string('document_url')->nullable(); // URL dokumen legalitas (misal: scan akta yayasan untuk verifikasi, boleh kosong)

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_details');
    }
};