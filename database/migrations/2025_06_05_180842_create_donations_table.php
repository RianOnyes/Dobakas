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
        Schema::create('donations', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap donasi

            // Kunci asing ke tabel users (donatur). Jika donatur dihapus, donasinya juga dihapus.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('title'); // Judul barang (misal: "Baju Bekas Anak", "Buku Pelajaran")
            $table->text('description')->nullable(); // Deskripsi detail barang dan kondisinya (boleh kosong)
            $table->string('category'); // Kategori (misal: 'Pakaian', 'Buku', 'Elektronik', 'Perabot')
            $table->json('photos')->nullable(); // Menyimpan URL foto barang dalam format JSON array (boleh kosong)

            // Status donasi:
            // 'pending': Baru diunggah oleh donatur, menunggu diverifikasi/dikelola admin
            // 'available': Sudah diverifikasi admin, siap diklaim panti asuhan
            // 'claimed': Sudah diklaim oleh panti asuhan
            // 'completed': Sudah diserahkan ke panti asuhan dan dikonfirmasi
            // 'cancelled': Donasi dibatalkan
            $table->enum('status', ['pending', 'available', 'claimed', 'completed', 'cancelled'])->default('pending');

            // Preferensi penyerahan barang oleh donatur:
            // 'self_deliver': Donatur mengantar sendiri ke pusat admin
            // 'needs_pickup': Donatur butuh penjemputan oleh admin
            $table->enum('pickup_preference', ['self_deliver', 'needs_pickup'])->default('self_deliver');

            $table->string('location')->nullable(); // Alamat/lokasi barang donatur (boleh kosong, bisa diambil dari profil user)

            // Kunci asing ke tabel users (Organisasi yang mengklaim donasi). Jika organisasi dihapus, kolom ini jadi NULL.
            $table->foreignId('claimed_by_organization_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps(); // created_at dan updated_at (Laravel otomatis mengisi ini)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};