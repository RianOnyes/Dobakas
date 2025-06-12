<x-dashboard-layout>
    <x-slot name="header">Statistik & Laporan</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto space-y-4 sm:space-y-6">

            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col space-y-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
                        <div>
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Filter Data</h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Pilih periode waktu untuk melihat statistik</p>
                        </div>
                        
                        <form method="GET" action="{{ route('admin.statistics') }}" class="w-full lg:w-auto">
                            <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:space-x-2 lg:space-x-4">
                                <select name="period" id="period" class="rounded-md border-gray-300 text-xs sm:text-sm focus:border-berkah-teal focus:ring-berkah-teal">
                                    <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua Data</option>
                                    <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                                    <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>

                                <div id="custom-dates" class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-2 {{ $period !== 'custom' ? 'hidden' : '' }}">
                                    <input type="date" name="start_date" value="{{ $startDate }}" 
                                           class="rounded-md border-gray-300 text-xs sm:text-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                           placeholder="Tanggal Mulai">
                                    <input type="date" name="end_date" value="{{ $endDate }}"
                                           class="rounded-md border-gray-300 text-xs sm:text-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                           placeholder="Tanggal Akhir">
                                </div>

                                <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-2">
                                    <button type="submit" class="px-3 py-2 sm:px-4 bg-berkah-teal text-white rounded-md hover:bg-berkah-hijau-gelap transition-colors text-xs sm:text-sm font-medium">
                                        Filter
                                    </button>

                                    <a href="{{ route('admin.statistics.export', request()->query()) }}" 
                                       class="px-3 py-2 sm:px-4 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors flex items-center justify-center text-xs sm:text-sm font-medium">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Export CSV
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Current Period Info -->
            @if($period !== 'all')
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-blue-800 text-xs sm:text-sm font-medium">
                        Menampilkan data untuk periode: 
                        @if($period === 'today') Hari Ini
                        @elseif($period === 'week') Minggu Ini
                        @elseif($period === 'month') Bulan Ini
                        @elseif($period === 'year') Tahun Ini
                        @elseif($period === 'custom') 
                            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '-' }} - 
                            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '-' }}
                        @endif
                    </span>
                </div>
            </div>
            @endif

            <!-- Main Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Pengguna</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($stats['total_users']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donatur -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Donatur</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($stats['total_donatur']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organizations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Organisasi</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($stats['total_organisasi']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Donations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Donasi</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($stats['total_donations']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($period !== 'all')
            <!-- Period-specific stats row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                <!-- New Users This Period -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pengguna Baru Periode Ini</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($stats['new_users_this_period']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Donations This Period -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Donasi Baru Periode Ini</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($stats['total_donations']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Claims This Period -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Donasi Diklaim Periode Ini</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($stats['claims_this_period'] ?? 0) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- User Growth Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pertumbuhan Pengguna</h3>
                        <div class="h-64 sm:h-80">
                            <canvas id="userGrowthChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Donation Status Distribution -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Distribusi Status Donasi</h3>
                        <div class="h-64 sm:h-80">
                            <canvas id="donationStatusChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Distribusi Kategori Donasi</h3>
                    <div class="h-64 sm:h-80">
                        <canvas id="categoryChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detailed Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Top Donatur -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Top Donatur</h3>
                        
                        <!-- Mobile view (cards) -->
                        <div class="block lg:hidden space-y-3">
                            @forelse($topDonatur as $index => $donatur)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-berkah-teal text-white text-xs font-medium mr-2">
                                            {{ $index + 1 }}
                                        </span>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $donatur->name }}</h4>
                                    </div>
                                    <span class="text-sm font-semibold text-berkah-teal">{{ $donatur->donations_count }} donasi</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">{{ $donatur->email }}</p>
                            </div>
                            @empty
                            <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">Belum ada data donatur.</p>
                            @endforelse
                        </div>

                        <!-- Desktop view (table) -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Donasi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($topDonatur as $index => $donatur)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $donatur->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $donatur->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $donatur->donations_count }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada data donatur.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Organizations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Top Organisasi</h3>
                        
                        <!-- Mobile view (cards) -->
                        <div class="block lg:hidden space-y-3">
                            @forelse($topOrganizations as $index => $org)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-medium mr-2">
                                            {{ $index + 1 }}
                                        </span>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $org->name }}</h4>
                                    </div>
                                    <span class="text-sm font-semibold text-purple-600">{{ $org->claimed_donations_count }} klaim</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">{{ $org->email }}</p>
                            </div>
                            @empty
                            <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">Belum ada data organisasi.</p>
                            @endforelse
                        </div>

                        <!-- Desktop view (table) -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Klaim</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($topOrganizations as $index => $org)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $org->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $org->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $org->claimed_donations_count }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada data organisasi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Aktivitas Terbaru</h3>
                    
                    <!-- Mobile view (cards) -->
                    <div class="block lg:hidden space-y-3">
                        @forelse($recentActivity as $activity)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $activity->title }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $activity->user->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $activity->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $activity->getStatusBadgeClass() }} ml-2 flex-shrink-0">
                                    {{ $activity->getStatusLabel() }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">Belum ada aktivitas terbaru.</p>
                        @endforelse
                    </div>

                    <!-- Desktop view (table) -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aktivitas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($recentActivity as $activity)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($activity->title, 40) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $activity->user->name ?? 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activity->getStatusBadgeClass() }}">
                                            {{ $activity->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada aktivitas terbaru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Mobile-responsive chart configuration
        const responsiveOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: window.innerWidth < 640 ? 'bottom' : 'top',
                    labels: {
                        fontSize: window.innerWidth < 640 ? 10 : 12,
                        padding: window.innerWidth < 640 ? 10 : 20
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        fontSize: window.innerWidth < 640 ? 10 : 12
                    }
                },
                y: {
                    ticks: {
                        fontSize: window.innerWidth < 640 ? 10 : 12
                    }
                }
            }
        };

        // User Growth Chart
        const userCtx = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthChart = new Chart(userCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['user_growth']['labels']) !!},
                datasets: [{
                    label: 'Pengguna Baru',
                    data: {!! json_encode($chartData['user_growth']['data']) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: responsiveOptions
        });

        // Donation Status Chart
        const statusCtx = document.getElementById('donationStatusChart').getContext('2d');
        const donationStatusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartData['donation_status']['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chartData['donation_status']['data']) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ]
                }]
            },
            options: {
                ...responsiveOptions,
                cutout: window.innerWidth < 640 ? '50%' : '60%'
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['categories']['labels']) !!},
                datasets: [{
                    label: 'Jumlah Donasi',
                    data: {!! json_encode($chartData['categories']['data']) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: responsiveOptions
        });

        // Custom date toggle
        document.getElementById('period').addEventListener('change', function() {
            const customDates = document.getElementById('custom-dates');
            if (this.value === 'custom') {
                customDates.classList.remove('hidden');
            } else {
                customDates.classList.add('hidden');
            }
        });

        // Responsive chart resize
        window.addEventListener('resize', function() {
            const isMobile = window.innerWidth < 640;
            
            [userGrowthChart, donationStatusChart, categoryChart].forEach(chart => {
                if (chart.options.plugins.legend) {
                    chart.options.plugins.legend.position = isMobile ? 'bottom' : 'top';
                    chart.options.plugins.legend.labels.fontSize = isMobile ? 10 : 12;
                    chart.options.plugins.legend.labels.padding = isMobile ? 10 : 20;
                }
                
                if (chart.config.type === 'doughnut') {
                    chart.options.cutout = isMobile ? '50%' : '60%';
                }
                
                chart.update();
            });
        });
    </script>
    @endpush
</x-dashboard-layout> 