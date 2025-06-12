<x-dashboard-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Profile Information Card -->
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-berkah-primary to-berkah-secondary rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2C8.5 2 8 2.5 8 4s.5 2 2 2 2-.5 2-2-.5-2-2-2zM10 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Informasi Profil</h2>
                            <p class="text-sm text-gray-600">Perbarui informasi profil dan alamat email akun Anda</p>
                        </div>
                    </div>

                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-berkah-primary to-berkah-secondary rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Ubah Password</h2>
                            <p class="text-sm text-gray-600">Pastikan akun Anda menggunakan password yang panjang dan acak untuk keamanan</p>
                        </div>
                    </div>

                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Role-specific Information -->
            @if(auth()->user()->role === 'organisasi')
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-berkah-primary to-berkah-secondary rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Informasi Organisasi</h2>
                            <p class="text-sm text-gray-600">Kelola detail organisasi Anda untuk membantu donatur mengenal organisasi Anda</p>
                        </div>
                    </div>

                    <div class="text-center py-8">
                        <p class="text-gray-600 mb-4">Lengkapi profil organisasi Anda untuk mendapatkan lebih banyak donasi</p>
                        <a href="{{ route('organisasi.profile') }}" class="inline-flex items-center px-4 py-2 bg-berkah-secondary hover:bg-berkah-primary text-white font-semibold rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            Kelola Profil Organisasi
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Account Statistics -->
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-berkah-primary to-berkah-secondary rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Statistik Akun</h2>
                            <p class="text-sm text-gray-600">Ringkasan aktivitas Anda di platform Berkah BaBe</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @if(auth()->user()->role === 'donatur')
                        <div class="bg-berkah-cream/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-berkah-primary">{{ auth()->user()->donations()->count() }}</div>
                            <div class="text-sm text-gray-600">Total Donasi</div>
                        </div>
                        <div class="bg-berkah-cream/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-berkah-secondary">{{ auth()->user()->donations()->where('status', 'completed')->count() }}</div>
                            <div class="text-sm text-gray-600">Donasi Selesai</div>
                        </div>
                        <div class="bg-berkah-cream/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-berkah-accent">{{ auth()->user()->donations()->whereIn('status', ['pending', 'available', 'claimed'])->count() }}</div>
                            <div class="text-sm text-gray-600">Donasi Aktif</div>
                        </div>
                        @elseif(auth()->user()->role === 'organisasi')
                        <div class="bg-berkah-cream/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-berkah-primary">{{ auth()->user()->claimedDonations()->count() }}</div>
                            <div class="text-sm text-gray-600">Total Diklaim</div>
                        </div>
                        <div class="bg-berkah-cream/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-berkah-secondary">{{ auth()->user()->claimedDonations()->where('status', 'completed')->count() }}</div>
                            <div class="text-sm text-gray-600">Donasi Selesai</div>
                        </div>
                        <div class="bg-berkah-cream/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-berkah-accent">{{ auth()->user()->donationRequests()->where('status', 'active')->count() }}</div>
                            <div class="text-sm text-gray-600">Permintaan Aktif</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-berkah-primary to-berkah-secondary rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Informasi Akun</h2>
                            <p class="text-sm text-gray-600">Detail tentang akun dan status verifikasi Anda</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-berkah-accent/20">
                            <span class="text-gray-600">Role:</span>
                            <span class="px-3 py-1 bg-berkah-secondary text-white text-sm rounded-full">{{ ucfirst(auth()->user()->role) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-berkah-accent/20">
                            <span class="text-gray-600">Status Verifikasi:</span>
                            <span class="px-3 py-1 {{ auth()->user()->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} text-sm rounded-full">
                                {{ auth()->user()->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-berkah-accent/20">
                            <span class="text-gray-600">Bergabung Sejak:</span>
                            <span class="text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Terakhir Update:</span>
                            <span class="text-gray-900">{{ auth()->user()->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-red-200">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z"/>
                                <path d="M11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-red-900">Zona Berbahaya</h2>
                            <p class="text-sm text-red-700">Tindakan permanen yang tidak dapat dibatalkan</p>
                        </div>
                    </div>

                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
