<x-dashboard-layout>
    <x-slot name="header">Statistik & Laporan</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto space-y-4 sm:space-y-6">

            <!-- Filter Section -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col space-y-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
                        <div>
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">Filter Data</h3>
                            <p class="text-xs sm:text-sm text-gray-500">Pilih periode waktu untuk
                                melihat statistik</p>
                        </div>

                        <form method="GET" action="{{ route('admin.statistics') }}" class="w-full lg:w-auto">
                            <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:space-x-2 lg:space-x-4">
                                <select name="period" id="period"
                                    class="rounded-md border-gray-300 text-xs sm:text-sm focus:border-berkah-teal focus:ring-berkah-teal">
                                    <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua Data</option>
                                    <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                                    <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>

                                <div id="custom-dates"
                                    class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-2 {{ $period !== 'custom' ? 'hidden' : '' }}">
                                    <input type="date" name="start_date" value="{{ $startDate }}"
                                        class="rounded-md border-gray-300 text-xs sm:text-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                        placeholder="Tanggal Mulai">
                                    <input type="date" name="end_date" value="{{ $endDate }}"
                                        class="rounded-md border-gray-300 text-xs sm:text-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                        placeholder="Tanggal Akhir">
                                </div>

                                <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-2">
                                    <button type="submit"
                                        class="px-3 py-2 sm:px-4 bg-berkah-teal text-white rounded-md hover:bg-berkah-hijau-gelap transition-colors text-xs sm:text-sm font-medium">
                                        Filter
                                    </button>

                                    <a href="{{ route('admin.statistics.export', request()->query()) }}"
                                        class="px-3 py-2 sm:px-4 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors flex items-center justify-center text-xs sm:text-sm font-medium">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
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
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-blue-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt
                                        class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Pengguna</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 ">
                                        {{ number_format($stats['total_users']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donatur -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-green-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt
                                        class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Donatur</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 ">
                                        {{ number_format($stats['total_donatur']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organizations -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-purple-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt
                                        class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Organisasi</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 ">
                                        {{ number_format($stats['total_organisasi']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Donations -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 text-yellow-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt
                                        class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Donasi</dt>
                                    <dd class="text-sm sm:text-lg font-medium text-gray-900 ">
                                        {{ number_format($stats['total_donations']) }}
                                    </dd>
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
                    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-3 h-3 sm:w-5 sm:h-5 text-blue-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                    <dl>
                                        <dt
                                            class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                            Pengguna Baru Periode Ini</dt>
                                        <dd class="text-sm sm:text-lg font-medium text-gray-900 ">
                                            {{ number_format($stats['new_users_this_period']) }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Donations This Period -->
                    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-6 h-6 sm:w-8 sm:h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-3 h-3 sm:w-5 sm:h-5 text-green-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                    <dl>
                                        <dt
                                            class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                            Donasi Baru Periode Ini</dt>
                                        <dd class="text-sm sm:text-lg font-medium text-gray-900 ">
                                            {{ number_format($stats['total_donations']) }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Claims This Period -->
                    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-6 h-6 sm:w-8 sm:h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-3 h-3 sm:w-5 sm:h-5 text-purple-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                    <dl>
                                        <dt
                                            class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                            Donasi Diklaim Periode Ini</dt>
                                        <dd class="text-sm sm:text-lg font-medium text-gray-900 ">
                                            {{ number_format($stats['claims_this_period'] ?? 0) }}
                                        </dd>
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
                <!-- <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Total Permintaan Donasi</h3>
                        <div class="h-64 sm:h-80 relative">
                            <canvas id="userGrowthChart" class="w-full h-full"></canvas>
                            @if(empty($chartData['donation_requests']['data']) || array_sum($chartData['donation_requests']['data'] ?? []) == 0)
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada data permintaan donasi</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div> -->

                <!-- Donation Status Distribution -->
                <!-- <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Persebaran Pengguna</h3>
                        <div class="h-64 sm:h-80 relative">
                            <canvas id="donationStatusChart" class="w-full h-full"></canvas>
                            @if(empty($chartData['user_distribution']['data']) || array_sum($chartData['user_distribution']['data'] ?? []) == 0)
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada data pengguna</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Category Distribution -->
            <!-- <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Distribusi Kategori Donasi</h3>
                    <div class="h-64 sm:h-80 relative">
                        <canvas id="categoryChart" class="w-full h-full"></canvas>
                        @if(empty($chartData['categories']['data']) || array_sum($chartData['categories']['data'] ?? []) == 0)
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada data kategori</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div> -->


            <!-- Detailed Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Top Donatur -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Top Donatur
                        </h3>

                        <!-- Mobile view (cards) -->
                        <div class="block lg:hidden space-y-3">
                            @forelse($topDonatur as $index => $donatur)
                                <div class="bg-berkah-cream/50 rounded-lg p-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <span
                                                class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-berkah-teal text-white text-xs font-medium mr-2">
                                                {{ $index + 1 }}
                                            </span>
                                            <h4 class="text-sm font-medium text-gray-900 ">
                                                {{ $donatur->name }}
                                            </h4>
                                        </div>
                                        <span class="text-sm font-semibold text-berkah-teal">{{ $donatur->donations_count }}
                                            donasi</span>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $donatur->email }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4">Belum ada data donatur.
                                </p>
                            @endforelse
                        </div>

                        <!-- Desktop view (table) -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-berkah-cream/30">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Donasi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/50 divide-y divide-gray-200">
                                    @forelse($topDonatur as $index => $donatur)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                                                {{ $index + 1 }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                                                {{ $donatur->name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $donatur->email }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                                                {{ $donatur->donations_count }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                Belum ada data donatur.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Organizations -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Top
                            Organisasi</h3>

                        <!-- Mobile view (cards) -->
                        <div class="block lg:hidden space-y-3">
                            @forelse($topOrganizations as $index => $org)
                                <div class="bg-berkah-cream/50 rounded-lg p-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <span
                                                class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-medium mr-2">
                                                {{ $index + 1 }}
                                            </span>
                                            <h4 class="text-sm font-medium text-gray-900 ">
                                                {{ $org->name }}
                                            </h4>
                                        </div>
                                        <span class="text-sm font-semibold text-purple-600">{{ $org->donations_count ?? 0 }}
                                            klaim</span>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $org->email }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4">Belum ada data
                                    organisasi.</p>
                            @endforelse
                        </div>

                        <!-- Desktop view (table) -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-berkah-cream/30">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Klaim</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/50 divide-y divide-gray-200">
                                    @forelse($topOrganizations as $index => $org)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                                                {{ $index + 1 }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                                                {{ $org->name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $org->email }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                                                {{ $org->donations_count ?? 0 }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                Belum ada data organisasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Aktivitas Terbaru
                    </h3>

                    <!-- Mobile view (cards) -->
                    <div class="block lg:hidden space-y-3">
                        @forelse($recentActivities as $activity)
                            <div class="bg-berkah-cream/50 rounded-lg p-3">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">
                                            {{ $activity['message'] ?? 'Unknown Activity' }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $activity['user_name'] ?? 'Unknown' }}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                            {{ isset($activity['created_at']) ? $activity['created_at']->format('d/m/Y H:i') : '-' }}
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 ml-2 flex-shrink-0">
                                        {{ ucfirst($activity['status'] ?? 'unknown') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center py-4">Belum ada aktivitas
                                terbaru.</p>
                        @endforelse
                    </div>

                    <!-- Desktop view (table) -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-berkah-cream/30">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aktivitas</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengguna</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-gray-200">
                                @forelse($recentActivities as $activity)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                                            {{ Str::limit($activity['message'] ?? 'Unknown Activity', 40) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity['user_name'] ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                                {{ ucfirst($activity['status'] ?? 'unknown') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ isset($activity['created_at']) ? $activity['created_at']->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500"> Belum ada aktivitas terbaru.</td>
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
        <script>
            // Wait for DOM to be ready
            document.addEventListener('DOMContentLoaded', function () {
                console.log('DOM loaded, checking Chart.js...');

                // Check if Chart.js is loaded
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded');
                    return;
                }

                console.log('Chart.js loaded successfully:', Chart.version);
                // Mobile-responsive chart configuration
                const responsiveOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: window.innerWidth < 640 ? 'bottom' : 'top',
                            labels: {
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                },
                                padding: window.innerWidth < 640 ? 10 : 20
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        },
                        y: {
                            ticks: {
                                font: {
                                    size: window.innerWidth < 640 ? 10 : 12
                                }
                            }
                        }
                    }
                };

                // Prepare chart data with error handling
                const chartData = @json($chartData ?? []);

                // Debug: Log chart data to console
                console.log('Chart Data:', chartData);
                console.log('User Distribution Data:', chartData.user_distribution);
                console.log('Donation Requests Data:', chartData.donation_requests);
                console.log('Categories Data:', chartData.categories);

                // Check if we have any data at all
                if (!chartData || Object.keys(chartData).length === 0) {
                    console.warn('No chart data available');
                }

                // Total Donation Requests Chart (Bar Chart)
                const userCtx = document.getElementById('userGrowthChart');
                if (userCtx && chartData.donation_requests) {
                    const donationRequestsData = chartData.donation_requests.data || [];
                    const donationRequestsLabels = chartData.donation_requests.labels || [];

                    console.log('Donation Requests Data:', donationRequestsData);

                    // Check if there's any data
                    const hasRequestData = donationRequestsData.some(value => value > 0);

                    if (hasRequestData || donationRequestsLabels.length > 0) {
                        const donationRequestsChart = new Chart(userCtx, {
                            type: 'bar',
                            data: {
                                labels: donationRequestsLabels,
                                datasets: [{
                                    label: 'Jumlah Donasi',
                                    data: donationRequestsData,
                                    backgroundColor: [
                                        'rgba(251, 191, 36, 0.8)',   // Pending - Yellow
                                        'rgba(34, 197, 94, 0.8)',    // Available - Green
                                        'rgba(59, 130, 246, 0.8)',   // Claimed - Blue
                                        'rgba(107, 114, 128, 0.8)',  // Completed - Gray
                                        'rgba(239, 68, 68, 0.8)'     // Cancelled - Red
                                    ],
                                    borderColor: [
                                        'rgba(251, 191, 36, 1)',
                                        'rgba(34, 197, 94, 1)',
                                        'rgba(59, 130, 246, 1)',
                                        'rgba(107, 114, 128, 1)',
                                        'rgba(239, 68, 68, 1)'
                                    ],
                                    borderWidth: 2,
                                    borderRadius: 4,
                                    borderSkipped: false,
                                }]
                            },
                            options: {
                                ...responsiveOptions,
                                plugins: {
                                    ...responsiveOptions.plugins,
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderWidth: 1
                                    },
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    ...responsiveOptions.scales,
                                    y: {
                                        ...responsiveOptions.scales.y,
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        }
                                    },
                                    x: {
                                        ...responsiveOptions.scales.x,
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        // Show no data message
                        const ctx = userCtx.getContext('2d');
                        ctx.font = '14px Arial';
                        ctx.fillStyle = '#6B7280';
                        ctx.textAlign = 'center';
                        ctx.fillText('Belum ada data permintaan donasi', userCtx.width / 2, userCtx.height / 2);
                    }
                }

                // User Distribution Chart (Pie Chart)
                const statusCtx = document.getElementById('donationStatusChart');
                if (statusCtx && chartData.user_distribution) {
                    const userDistData = chartData.user_distribution.data || [];
                    const userDistLabels = chartData.user_distribution.labels || [];

                    console.log('User Distribution Data:', userDistData);

                    // Check if there's any data
                    const hasUserData = userDistData.some(value => value > 0);

                    if (hasUserData) {
                        const userDistributionChart = new Chart(statusCtx, {
                            type: 'pie',
                            data: {
                                labels: userDistLabels,
                                datasets: [{
                                    data: userDistData,
                                    backgroundColor: [
                                        'rgba(20, 184, 166, 0.8)',   // Donatur - Teal
                                        'rgba(147, 51, 234, 0.8)',   // Organisasi - Purple
                                    ],
                                    borderColor: [
                                        'rgba(20, 184, 166, 1)',
                                        'rgba(147, 51, 234, 1)',
                                    ],
                                    borderWidth: 3
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: window.innerWidth < 640 ? 'bottom' : 'right',
                                        labels: {
                                            font: {
                                                size: window.innerWidth < 640 ? 12 : 14
                                            },
                                            padding: 20,
                                            usePointStyle: true
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderWidth: 1,
                                        callbacks: {
                                            label: function (context) {
                                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                                return context.label + ': ' + context.parsed + ' pengguna (' + percentage + '%)';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        // Show no data message
                        const ctx = statusCtx.getContext('2d');
                        ctx.font = '14px Arial';
                        ctx.fillStyle = '#6B7280';
                        ctx.textAlign = 'center';
                        ctx.fillText('Belum ada data pengguna', statusCtx.width / 2, statusCtx.height / 2);
                    }
                }

                // Category Chart
                const categoryCtx = document.getElementById('categoryChart');
                if (categoryCtx && chartData.categories) {
                    const categoryData = chartData.categories.data || [];
                    const categoryLabels = chartData.categories.labels || [];

                    // Check if there's any data
                    const hasCategoryData = categoryData.some(value => value > 0);

                    if (hasCategoryData && categoryLabels.length > 0) {
                        const categoryChart = new Chart(categoryCtx, {
                            type: 'bar',
                            data: {
                                labels: categoryLabels,
                                datasets: [{
                                    label: 'Jumlah Donasi',
                                    data: categoryData,
                                    backgroundColor: 'rgba(20, 184, 166, 0.8)',
                                    borderColor: 'rgba(20, 184, 166, 1)',
                                    borderWidth: 2,
                                    borderRadius: 4,
                                    borderSkipped: false,
                                }]
                            },
                            options: {
                                ...responsiveOptions,
                                plugins: {
                                    ...responsiveOptions.plugins,
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderColor: 'rgb(20, 184, 166)',
                                        borderWidth: 1
                                    }
                                },
                                scales: {
                                    ...responsiveOptions.scales,
                                    y: {
                                        ...responsiveOptions.scales.y,
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        }
                                    },
                                    x: {
                                        ...responsiveOptions.scales.x,
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        // Show no data message
                        const ctx = categoryCtx.getContext('2d');
                        ctx.font = '14px Arial';
                        ctx.fillStyle = '#6B7280';
                        ctx.textAlign = 'center';
                        ctx.fillText('Belum ada data kategori', categoryCtx.width / 2, categoryCtx.height / 2);
                    }
                }

                // Custom date toggle
                const periodSelect = document.getElementById('period');
                if (periodSelect) {
                    periodSelect.addEventListener('change', function () {
                        const customDates = document.getElementById('custom-dates');
                        if (customDates) {
                            if (this.value === 'custom') {
                                customDates.classList.remove('hidden');
                            } else {
                                customDates.classList.add('hidden');
                            }
                        }
                    });
                }

                // Responsive chart resize
                window.addEventListener('resize', function () {
                    const isMobile = window.innerWidth < 640;

                    // Update all charts if they exist
                    Chart.instances.forEach(chart => {
                        if (chart.options.plugins && chart.options.plugins.legend) {
                            chart.options.plugins.legend.position = isMobile ? 'bottom' : 'top';
                            if (chart.config.type === 'doughnut') {
                                chart.options.plugins.legend.position = isMobile ? 'bottom' : 'right';
                            }
                            chart.options.plugins.legend.labels.font.size = isMobile ? 10 : 12;
                            chart.options.plugins.legend.labels.padding = isMobile ? 10 : 20;
                        }

                        if (chart.config.type === 'doughnut') {
                            chart.options.cutout = isMobile ? '50%' : '60%';
                        }

                        chart.update();
                    });
                });

                // Test function for Chart.js
                window.testChart = function () {
                    if (typeof Chart === 'undefined') {
                        alert('Chart.js is NOT loaded!');
                        return;
                    }

                    alert('Chart.js is loaded! Version: ' + Chart.version + '\nTotal chart instances: ' + Chart.instances.length);
                    console.log('Chart.js status:', {
                        loaded: typeof Chart !== 'undefined',
                        version: Chart.version,
                        instances: Chart.instances.length,
                        chartData: @json($chartData ?? [])
                    });
                };
            });
        </script>
    @endpush
</x-dashboard-layout>
