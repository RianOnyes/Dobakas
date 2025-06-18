<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\OrganizationDetail;
use Illuminate\Support\Facades\Hash;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample organizations
        $organizations = [
            [
                'user' => [
                    'name' => 'Panti Asuhan Harapan Bangsa',
                    'email' => 'admin@pantiharapan.org',
                    'role' => 'organisasi',
                    'email_verified_at' => now(),
                ],
                'details' => [
                    'organization_name' => 'Panti Asuhan Harapan Bangsa',
                    'contact_person' => 'Ibu Sari Widyaningsih',
                    'contact_phone' => '0812-3456-7890',
                    'organization_address' => 'Jl. Melati No. 15, Kelurahan Sukamaju, Kecamatan Kramat Jati, Jakarta Timur',
                    'description' => 'Panti asuhan yang menampung 45 anak yatim piatu dari berbagai usia. Kami berkomitmen memberikan pendidikan dan kasih sayang kepada anak-anak yang membutuhkan. Berdiri sejak 1995, kami telah membantu ratusan anak untuk memiliki masa depan yang lebih baik.',
                    'needs_list' => ['Pakaian Anak', 'Buku Sekolah', 'Alat Tulis', 'Sepatu', 'Makanan'],
                ]
            ],
            [
                'user' => [
                    'name' => 'Yayasan Peduli Sesama',
                    'email' => 'info@pedulisesama.org',
                    'role' => 'organisasi',
                    'email_verified_at' => now(),
                ],
                'details' => [
                    'organization_name' => 'Yayasan Peduli Sesama',
                    'contact_person' => 'Bapak Ahmad Sutrisno',
                    'contact_phone' => '0856-7890-1234',
                    'organization_address' => 'Jl. Mawar Putih No. 88, Kelurahan Cipinang Besar, Jakarta Timur',
                    'description' => 'Yayasan sosial yang fokus membantu masyarakat kurang mampu dan anak jalanan. Kami menyediakan tempat tinggal sementara, pendidikan non-formal, dan pelatihan keterampilan untuk memandirikan mereka.',
                    'needs_list' => ['Elektronik Bekas', 'Furniture', 'Pakaian Dewasa', 'Peralatan Masak'],
                ]
            ],
            [
                'user' => [
                    'name' => 'Panti Jompo Sejahtera',
                    'email' => 'contact@pantijomposejahtera.org',
                    'role' => 'organisasi',
                    'email_verified_at' => now(),
                ],
                'details' => [
                    'organization_name' => 'Panti Jompo Sejahtera',
                    'contact_person' => 'Ibu Dr. Retno Sari',
                    'contact_phone' => '0821-9876-5432',
                    'organization_address' => 'Jl. Kenanga Raya No. 22, Kelurahan Duren Sawit, Jakarta Timur',
                    'description' => 'Panti jompo yang merawat lansia yang tidak memiliki keluarga atau keluarga yang tidak mampu merawat. Kami menyediakan perawatan kesehatan, makanan bergizi, dan aktivitas untuk menjaga kesehatan mental para lansia.',
                    'needs_list' => ['Alat Kesehatan', 'Obat-obatan', 'Kursi Roda', 'Tempat Tidur Medis', 'Pakaian Lansia'],
                ]
            ],
            [
                'user' => [
                    'name' => 'Rumah Singgah Anak Jalanan',
                    'email' => 'admin@rumahsinggah.org',
                    'role' => 'organisasi',
                    'email_verified_at' => now(),
                ],
                'details' => [
                    'organization_name' => 'Rumah Singgah Anak Jalanan',
                    'contact_person' => 'Pak Joko Santoso',
                    'contact_phone' => '0813-5555-6666',
                    'organization_address' => 'Jl. Flamboyan No. 7, Kelurahan Cakung Timur, Jakarta Timur',
                    'description' => 'Rumah singgah yang memberikan tempat aman untuk anak jalanan beristirahat, mandi, makan, dan belajar. Kami juga memberikan pendampingan psikologis dan pelatihan keterampilan hidup.',
                    'needs_list' => ['Sabun Mandi', 'Handuk', 'Buku Cerita', 'Mainan Edukasi', 'Peralatan Olahraga'],
                ]
            ],
            [
                'user' => [
                    'name' => 'Komunitas Berbagi Jakarta',
                    'email' => 'hello@komunitasberbagi.org',
                    'role' => 'organisasi',
                    'email_verified_at' => now(),
                ],
                'details' => [
                    'organization_name' => 'Komunitas Berbagi Jakarta',
                    'contact_person' => 'Ibu Maya Sari',
                    'contact_phone' => '0877-1111-2222',
                    'organization_address' => 'Jl. Anggrek Putih No. 45, Kelurahan Klender, Jakarta Timur',
                    'description' => 'Komunitas yang bergerak di bidang pemberdayaan masyarakat dan bantuan sosial. Kami mengorganisir kegiatan berbagi makanan, pakaian, dan pendidikan untuk masyarakat kurang mampu di sekitar Jakarta Timur.',
                    'needs_list' => ['Tas Sekolah', 'Sepeda Bekas', 'Laptop Bekas', 'Proyektor', 'Buku Pelajaran'],
                ]
            ]
        ];

        foreach ($organizations as $org) {
            // Create user
            $user = User::create([
                'name' => $org['user']['name'],
                'email' => $org['user']['email'],
                'password' => Hash::make('password123'),
                'role' => $org['user']['role'],
                'email_verified_at' => $org['user']['email_verified_at'],
            ]);

            // Create organization details
            OrganizationDetail::create(array_merge(
                $org['details'],
                ['user_id' => $user->id]
            ));
        }
    }
}
