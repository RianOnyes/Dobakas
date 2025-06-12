<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\User;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the donatur user
        $donatur = User::where('email', 'donatur@test.com')->first();
        
        if (!$donatur) {
            $this->command->error('Donatur user not found. Please create the donatur user first.');
            return;
        }

        // Get a random organization for claimed donations
        $organization = User::where('role', 'organisasi')->first();

        // Create sample donations
        $donations = [
            [
                'title' => 'Baju Anak Bekas Layak Pakai',
                'description' => 'Kumpulan baju anak-anak ukuran 2-5 tahun dalam kondisi baik. Sudah dicuci bersih dan siap pakai. Total ada sekitar 15 potong baju dengan berbagai model dan warna.',
                'category' => 'Pakaian',
                'status' => 'available',
                'pickup_preference' => 'self_deliver',
                'location' => null,
                'claimed_by_organization_id' => null,
            ],
            [
                'title' => 'Buku Pelajaran SD Kelas 1-3',
                'description' => 'Kumpulan buku pelajaran untuk tingkat Sekolah Dasar kelas 1, 2, dan 3. Kondisi masih bagus, beberapa ada coretan pensil tapi masih bisa dibaca dengan jelas. Sudah sesuai kurikulum terbaru.',
                'category' => 'Buku',
                'status' => 'claimed',
                'pickup_preference' => 'needs_pickup',
                'location' => 'Jl. Raya Bekasi No. 123, Jakarta Timur',
                'claimed_by_organization_id' => $organization ? $organization->id : null,
            ],
            [
                'title' => 'Laptop Bekas Masih Berfungsi',
                'description' => 'Laptop Lenovo ThinkPad X240, kondisi masih berfungsi dengan baik. RAM 4GB, storage 500GB HDD. Sudah terinstall Windows 10 dan software office. Cocok untuk belajar dan bekerja.',
                'category' => 'Elektronik',
                'status' => 'pending',
                'pickup_preference' => 'self_deliver',
                'location' => null,
                'claimed_by_organization_id' => null,
            ],
            [
                'title' => 'Mainan Edukasi Anak',
                'description' => 'Berbagai mainan edukasi seperti puzzle, balok susun, dan mainan berhitung. Kondisi masih baik dan aman untuk anak-anak. Cocok untuk anak usia 3-8 tahun.',
                'category' => 'Mainan',
                'status' => 'completed',
                'pickup_preference' => 'needs_pickup',
                'location' => 'Jl. Kebon Jeruk No. 45, Jakarta Barat',
                'claimed_by_organization_id' => $organization ? $organization->id : null,
            ],
            [
                'title' => 'Sepatu Sekolah Anak Various Size',
                'description' => 'Kumpulan sepatu sekolah hitam untuk anak-anak berbagai ukuran (30-36). Kondisi masih layak pakai, sudah dibersihkan. Cocok untuk anak-anak sekolah dasar.',
                'category' => 'Pakaian',
                'status' => 'available',
                'pickup_preference' => 'self_deliver',
                'location' => null,
                'claimed_by_organization_id' => null,
            ],
            [
                'title' => 'Peralatan Masak Rumah Tangga',
                'description' => 'Set peralatan masak termasuk panci, wajan, sendok sayur, dan peralatan dapur lainnya. Kondisi masih baik dan bersih. Cocok untuk dapur organisasi atau panti.',
                'category' => 'Peralatan Rumah Tangga',
                'status' => 'cancelled',
                'pickup_preference' => 'needs_pickup',
                'location' => 'Jl. Cempaka No. 78, Jakarta Selatan',
                'claimed_by_organization_id' => null,
            ],
        ];

        foreach ($donations as $donationData) {
            Donation::create(array_merge($donationData, [
                'user_id' => $donatur->id,
                'photos' => [], // Empty for now, can be added later
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 15)),
            ]));
        }

        $this->command->info('Sample donations created successfully!');
    }
}
