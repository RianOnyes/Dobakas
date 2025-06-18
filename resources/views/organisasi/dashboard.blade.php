<x-dashboard-layout>
    <x-slot name="header">Dasbor Organisasi</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Welcome Message -->
            <div
                class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg mb-4 sm:mb-6 border border-berkah-accent/20">
                <div class="p-4 sm:p-6 text-gray-900">
                    <h3 class="text-base sm:text-lg font-semibold mb-2">Selamat datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-sm sm:text-base text-gray-600">
                        @if($organizationDetail)
                            Kelola donasi dan permintaan untuk {{ $organizationDetail->organization_name }}.
                        @else
                            <span class="text-orange-600">Silakan lengkapi profil organisasi Anda terlebih dahulu.</span>
                            <a href="{{ route('organisasi.profile') }}"
                                class="block sm:inline ml-0 sm:ml-2 mt-2 sm:mt-0 text-berkah-secondary hover:text-berkah-primary font-medium">Lengkapi
                                Profil →</a>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <div
                    class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 bg-berkah-secondary rounded-lg flex items-center justify-center">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Donasi
                                        Diklaim</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                        {{ number_format($stats['total_claimed']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 bg-berkah-primary rounded-lg flex items-center justify-center">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Donasi Selesai
                                    </dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                        {{ number_format($stats['completed_donations']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Dalam Proses</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                        {{ number_format($stats['pending_claims']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 bg-berkah-accent rounded-lg flex items-center justify-center">
                                    <svg class="h-6 w-6 text-berkah-primary" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Tersedia di Gudang
                                    </dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-900">
                                        {{ number_format($stats['available_donations']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Quick Actions -->
                <div
                    class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-1 gap-3 sm:gap-4">
                            <a href="{{ route('organisasi.warehouse-donations') }}"
                                class="group relative block p-3 sm:p-4 border border-berkah-accent/30 rounded-lg hover:border-berkah-secondary transition-colors bg-berkah-cream/30 hover:bg-berkah-cream/50">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 bg-berkah-secondary rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                        <h4
                                            class="text-sm sm:text-lg font-medium text-gray-900 group-hover:text-berkah-primary">
                                            Jelajahi Gudang Admin</h4>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Cari donasi yang tersedia untuk
                                            diklaim</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('organisasi.claimed-donations') }}"
                                class="group relative block p-3 sm:p-4 border border-berkah-accent/30 rounded-lg hover:border-berkah-secondary transition-colors bg-berkah-cream/30 hover:bg-berkah-cream/50">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 bg-berkah-accent rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="h-6 w-6 text-berkah-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                        <h4
                                            class="text-sm sm:text-lg font-medium text-gray-900 group-hover:text-berkah-primary">
                                            Kelola Donasi Diklaim</h4>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Lihat dan kelola donasi yang
                                            sudah diklaim</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('organisasi.profile') }}"
                                class="group relative block p-3 sm:p-4 border border-berkah-accent/30 rounded-lg hover:border-berkah-secondary transition-colors bg-berkah-cream/30 hover:bg-berkah-cream/50">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 bg-berkah-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                        <h4
                                            class="text-sm sm:text-lg font-medium text-gray-900 group-hover:text-berkah-primary">
                                            Profil Organisasi</h4>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola informasi organisasi
                                            Anda</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Claims -->
                <div
                    class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2 sm:mb-0">Donasi Terbaru</h3>
                            <a href="{{ route('organisasi.claimed-donations') }}"
                                class="text-sm text-berkah-secondary hover:text-berkah-primary transition-colors">Lihat
                                Semua</a>
                        </div>

                        @if($recentClaims->count() > 0)
                            <div class="space-y-3 sm:space-y-4">
                                @foreach($recentClaims as $claim)
                                    <div
                                        class="flex items-center justify-between p-3 bg-berkah-cream/30 rounded-lg border border-berkah-accent/20">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $claim->title }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">dari {{ $claim->user->name ?? 'Unknown' }}</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $claim->getStatusBadgeClass() }} ml-3 flex-shrink-0">
                                            {{ $claim->getStatusLabel() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Belum ada donasi yang diklaim.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Suggested Donations -->
            @if($suggestedDonations->count() > 0)
                <div
                    class="mt-4 sm:mt-6 bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2 sm:mb-0">Donasi yang Mungkin Anda
                                Minati</h3>
                            <a href="{{ route('organisasi.warehouse-donations') }}"
                                class="text-sm text-berkah-secondary hover:text-berkah-primary transition-colors">Lihat
                                Semua</a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                            @foreach($suggestedDonations as $donation)
                                <div
                                    class="border border-berkah-accent/30 bg-berkah-cream/20 rounded-lg p-3 sm:p-4 hover:shadow-md transition-shadow hover:bg-berkah-cream/30">
                                    <div class="flex items-start justify-between mb-2">
                                        <h4 class="text-sm font-medium text-gray-900 line-clamp-2 flex-1">{{ $donation->title }}
                                        </h4>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-berkah-secondary text-white ml-2 flex-shrink-0">
                                            Tersedia
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-3">{{ $donation->category }}</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-gray-500">dari {{ $donation->user->name ?? 'Unknown' }}</p>
                                        <a href="{{ route('organisasi.donation.show', $donation) }}"
                                            class="text-xs text-berkah-secondary hover:text-berkah-primary font-medium transition-colors">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
