<x-dashboard-layout>
    <x-slot name="header">Gudang Admin - Donasi Tersedia</x-slot>

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

            <!-- Page Header -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gudang Admin</h3>
                    <p class="text-gray-600">Jelajahi donasi yang tersedia di gudang admin dan klaim
                        sesuai kebutuhan organisasi Anda.</p>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('organisasi.warehouse-donations') }}"
                        class="flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Cari judul, kategori, atau deskripsi donasi..."
                                class="w-full rounded-md bg-slate-200 border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal">
                        </div>

                        <!-- Category Filter -->
                        <div class="sm:w-40">
                            <select name="category"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $categoryOption)
                                    <option value="{{ $categoryOption }}" {{ $category === $categoryOption ? 'selected' : '' }}>
                                        {{ $categoryOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Button -->
                        <button type="submit"
                            class="px-4 py-2 bg-berkah-teal text-white rounded-md hover:bg-berkah-teal-gelap transition-colors">
                            Cari
                        </button>

                        <!-- Reset Filter -->
                        @if($search || $category)
                            <a href="{{ route('organisasi.warehouse-donations') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Results Info -->
            <div class="mb-4 sm:mb-6">
                <div class="text-xs sm:text-sm text-gray-600 px-1">
                    Menampilkan {{ $donations->count() }} dari {{ $donations->total() }} donasi tersedia
                    @if($search || $category)
                        <span class="block sm:inline sm:ml-2 mt-1 sm:mt-0">
                            @if($search)
                                · Pencarian: "<strong>{{ $search }}</strong>"
                            @endif
                            @if($category)
                                · Kategori: "<strong>{{ $category }}</strong>"
                            @endif
                        </span>
                    @endif
                </div>
            </div>

            <!-- Donations Grid -->
            @if($donations->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-6">
                    @foreach($donations as $donation)
                        <div
                            class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                            <!-- Image -->
                            @if($donation->photos && count($donation->photos) > 0)
                                <img src="{{ asset('storage/' . $donation->photos[0]) }}" alt="{{ $donation->title }}"
                                    class="w-full h-40 sm:h-48 object-cover">
                            @else
                                <div class="w-full h-40 sm:h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-4 sm:p-6">
                                <!-- Status and Category -->
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="inline-flex items-center px-2 py-1 sm:px-2.5 sm:py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Tersedia
                                    </span>
                                    <span
                                        class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded flex-shrink-0">
                                        {{ $donation->category }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-sm sm:text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $donation->title }}
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-3">
                                    {{ $donation->description ?: 'Tidak ada deskripsi.' }}
                                </p>

                                <!-- Donatur Info -->
                                <div class="flex items-center mb-3 sm:mb-4">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 mr-2 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-xs sm:text-sm text-gray-600 truncate">
                                        Donatur: {{ $donation->user->name ?? 'Unknown' }}
                                    </span>
                                </div>

                                <!-- Pickup Preference -->
                                <div class="flex items-center mb-3 sm:mb-4">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 mr-2 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-xs sm:text-sm text-gray-600">
                                        {{ $donation->pickup_preference === 'self_deliver' ? 'Antar Sendiri' : 'Perlu Dijemput' }}
                                    </span>
                                </div>

                                <!-- Date -->
                                <div class="text-xs text-gray-500 mb-3 sm:mb-4">
                                    Diposting {{ $donation->created_at->diffForHumans() }}
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <a href="{{ route('organisasi.donation.show', $donation) }}"
                                        class="flex-1 text-center px-3 py-2 sm:px-4 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-xs sm:text-sm">
                                        Lihat Detail
                                    </a>
                                    <form method="POST" action="{{ route('organisasi.donation.claim', $donation) }}"
                                        class="flex-1" id="claimForm{{ $donation->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button"
                                            class="w-full px-3 py-2 sm:px-4 bg-berkah-teal text-white rounded-md hover:bg-berkah-hijau-gelap transition-colors text-xs sm:text-sm"
                                            onclick="showModal('claimModal{{ $donation->id }}', document.getElementById('claimForm{{ $donation->id }}'))">
                                            Klaim Donasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                    <div class="text-xs sm:text-sm text-gray-700">
                        Showing {{ $donations->firstItem() }} to {{ $donations->lastItem() }} of {{ $donations->total() }}
                        results
                    </div>

                    <div class="overflow-x-auto">
                        {{ $donations->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 sm:p-12 text-center">
                        <svg class="mx-auto h-16 w-16 sm:h-24 sm:w-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <h3 class="mt-4 text-base sm:text-lg font-medium text-gray-900 ">Tidak ada donasi
                            ditemukan</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            @if($search || $category)
                                Tidak ada donasi yang sesuai dengan filter Anda. Coba ubah kriteria pencarian.
                            @else
                                Belum ada donasi yang tersedia di gudang admin saat ini.
                            @endif
                        </p>
                        @if($search || $category)
                            <div class="mt-6">
                                <a href="{{ route('organisasi.warehouse-donations') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-hijau-gelap">
                                    Lihat Semua Donasi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Claim Confirmation Modals -->
    @foreach($donations as $donation)
        <x-confirmation-modal id="claimModal{{ $donation->id }}" title="Konfirmasi Klaim Donasi"
            message="Apakah Anda yakin ingin mengklaim donasi '{{ $donation->title }}'? Setelah diklaim, donasi ini akan menjadi tanggung jawab organisasi Anda."
            confirmText="Ya, Klaim Donasi" cancelText="Batal" confirmClass="bg-berkah-teal hover:bg-berkah-hijau-gelap" />
    @endforeach
</x-dashboard-layout>
