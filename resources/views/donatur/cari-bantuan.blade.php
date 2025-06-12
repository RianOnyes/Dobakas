<x-dashboard-layout>
    <x-slot name="header">Cari Bantuan</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Cari Organisasi yang Membutuhkan Bantuan</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Temukan panti asuhan dan organisasi yang membutuhkan donasi barang bekas Anda.</p>
                    
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('donatur.cari-bantuan') }}" class="space-y-4">
                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- Search Input -->
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       value="{{ $searchTerm }}"
                                       placeholder="Cari nama organisasi atau deskripsi kebutuhan..."
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            
                            <!-- Category Filter -->
                            <div class="md:w-64">
                                <select name="category" 
                                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                <svg class="h-5 w-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results -->
            @if($organizations->count() > 0)
                <!-- Results Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($organizations as $organization)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <!-- Organization Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                            {{ $organization->organization_name }}
                                        </h4>
                                        @if($organization->contact_person)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                PIC: {{ $organization->contact_person }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            Aktif
                                        </span>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($organization->description)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                        {{ Str::limit($organization->description, 150) }}
                                    </p>
                                @endif

                                <!-- Needs List -->
                                @if($organization->needs_list && count($organization->needs_list) > 0)
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Kebutuhan:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($organization->needs_list, 0, 3) as $need)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                    {{ $need }}
                                                </span>
                                            @endforeach
                                            @if(count($organization->needs_list) > 3)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                    +{{ count($organization->needs_list) - 3 }} lainnya
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Contact Info -->
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    @if($organization->contact_phone)
                                        <p class="flex items-center mb-1">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ $organization->contact_phone }}
                                        </p>
                                    @endif
                                    @if($organization->organization_address)
                                        <p class="flex items-start">
                                            <svg class="h-4 w-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ Str::limit($organization->organization_address, 100) }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <div class="flex gap-2">
                                    <a href="{{ route('donatur.organization.show', $organization) }}" 
                                       class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                        Lihat Detail
                                    </a>
                                    @if($organization->contact_phone)
                                        <a href="tel:{{ $organization->contact_phone }}" 
                                           class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        {{ $organizations->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <!-- No Results -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">Tidak ada organisasi ditemukan</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            @if($searchTerm || $category)
                                Coba gunakan kata kunci yang berbeda atau hapus filter pencarian.
                            @else
                                Belum ada organisasi yang terdaftar di sistem.
                            @endif
                        </p>
                        @if($searchTerm || $category)
                            <div class="mt-4">
                                <a href="{{ route('donatur.cari-bantuan') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800">
                                    Lihat Semua Organisasi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout> 