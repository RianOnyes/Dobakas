<x-dashboard-layout>
    <x-slot name="header">Dasbor Donatur</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Message -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6 text-gray-900">
                    <h3 class="text-base sm:text-lg font-semibold mb-2">
                        @if($activityInsights['days_since_last_donation'] !== null && $activityInsights['days_since_last_donation'] == 0)
                            Selamat datang kembali, {{ auth()->user()->name }}! 🎉
                        @elseif($activityInsights['days_since_last_donation'] !== null && $activityInsights['days_since_last_donation'] <= 7)
                            Halo, {{ auth()->user()->name }}! 
                        @else
                            Selamat datang kembali, {{ auth()->user()->name }}!
                        @endif
                    </h3>
                    @if($stats['total_donations'] == 0)
                        <p class="text-sm sm:text-base text-gray-600">
                            Selamat bergabung! Mulai perjalanan berbagi Anda dengan membuat donasi pertama.
                        </p>
                    @elseif($activityInsights['days_since_last_donation'] !== null && $activityInsights['days_since_last_donation'] == 0)
                        <p class="text-sm sm:text-base text-gray-600">
                            Terima kasih telah membuat donasi hari ini! Anda telah membantu {{ $stats['total_donations'] }} kali.
                        </p>
                    @elseif($stats['pending_donations'] > 0)
                        <p class="text-sm sm:text-base text-gray-600">
                            Anda memiliki {{ $stats['pending_donations'] }} donasi yang sedang menunggu verifikasi. Tim admin sedang memproses donasi Anda.
                        </p>
                    @elseif($stats['available_donations'] > 0)
                        <p class="text-sm sm:text-base text-gray-600">
                            Hebat! {{ $stats['available_donations'] }} donasi Anda tersedia untuk diklaim organisasi.
                        </p>
                    @elseif($stats['claimed_donations'] > 0)
                        <p class="text-sm sm:text-base text-gray-600">
                            {{ $stats['claimed_donations'] }} donasi Anda telah diklaim! Jangan lupa koordinasi untuk penyerahan.
                        </p>
                    @else
                        <p class="text-sm sm:text-base text-gray-600">
                            Siap membuat perubahan hari ini? Jelajahi permintaan donasi yang tersedia atau periksa riwayat donasi Anda.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 sm:h-8 sm:w-8 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">
                                        Total Donasi</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-900 ">
                                        {{ $stats['total_donations'] }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 sm:h-8 sm:w-8 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">
                                        Menunggu</dt>
                                                        <dd class="text-lg sm:text-xl font-medium text-gray-900 ">
                        {{ $stats['pending_donations'] + $stats['available_donations'] + $stats['claimed_donations'] }}
                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 sm:h-8 sm:w-8 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                                <dl>
                                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">
                                        Selesai</dt>
                                    <dd class="text-lg sm:text-xl font-medium text-gray-900 ">
                                        {{ $stats['completed_donations'] }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Aksi Cepat
                        </h3>
                        <div class="grid grid-cols-1 gap-3 sm:gap-4">
                            <a href="{{ route('donatur.buat-donasi') }}"
                                class="group relative block p-3 sm:p-4 border border-gray-300 rounded-lg hover:border-green-500 transition-colors">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-green-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.5v15m7.5-7.5h-15"></path>
                                    </svg>
                                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                        <h4
                                            class="text-sm sm:text-lg font-medium text-gray-900 group-hover:text-green-600">
                                            Buat Donasi Baru</h4>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Bagikan
                                            barang yang tidak lagi Anda butuhkan</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('donatur.cari-bantuan') }}"
                                class="group relative block p-3 sm:p-4 border border-gray-300 rounded-lg hover:border-blue-500 transition-colors">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-blue-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z">
                                        </path>
                                    </svg>
                                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                        <h4
                                            class="text-sm sm:text-lg font-medium text-gray-900 group-hover:text-blue-600">
                                            Cari Organisasi</h4>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Jelajahi
                                            organisasi yang membutuhkan bantuan</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('donatur.donasi-saya') }}"
                                class="group relative block p-3 sm:p-4 border border-gray-300 rounded-lg hover:border-purple-500 transition-colors">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-purple-500 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z">
                                        </path>
                                    </svg>
                                    <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                        <h4
                                            class="text-sm sm:text-lg font-medium text-gray-900 group-hover:text-purple-600">
                                            Donasi Saya</h4>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Lihat dan
                                            kelola donasi Anda</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2 sm:mb-0">
                                Aktivitas Terbaru</h3>
                            <a href="{{ route('donatur.riwayat') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Lihat
                                Riwayat</a>
                        </div>

                        @if($recentDonations->count() > 0)
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @foreach($recentDonations as $donation)
                                        <li class="relative pb-8">
                                            @if (!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $donation->getStatusBadgeClass() }}">
                                                        @if($donation->status === 'pending')
                                                            <svg class="h-5 w-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif($donation->status === 'available')
                                                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif($donation->status === 'claimed')
                                                            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        @elseif($donation->status === 'completed')
                                                            <svg class="h-5 w-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                        @else
                                                            <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                            </svg>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-900">
                                                                                                                         <a href="{{ route('donatur.donation.show', $donation) }}" class="hover:underline font-medium">
                                                                {{ $donation->title }}
                                                            </a>
                                                        </p>
                                                        <p class="text-xs text-gray-500">{{ $donation->category }}</p>
                                                        @if($donation->claimedByOrganization)
                                                            <p class="text-xs text-blue-600">Diklaim oleh {{ $donation->claimedByOrganization->name }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->getStatusBadgeClass() }}">
                                                            {{ $donation->getStatusLabel() }}
                                                        </span>
                                                        <p class="mt-1 text-xs">{{ $donation->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas
                                    terbaru</h3>
                                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat donasi pertama
                                    Anda.</p>
                                <div class="mt-6">
                                    <a href="{{ route('donatur.buat-donasi') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.5v15m7.5-7.5h-15"></path>
                                        </svg>
                                        Buat Donasi
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Personalized Insights -->
            @if($activityInsights['has_recent_activity'])
                <div class="mb-4 sm:mb-6">
                    @if($stats['available_donations'] > 0)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">
                                        Selamat! {{ $stats['available_donations'] }} donasi Anda telah tersedia untuk diklaim
                                    </h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p>Organisasi dapat melihat dan mengklaim donasi Anda sekarang.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($stats['claimed_donations'] > 0)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        {{ $stats['claimed_donations'] }} donasi Anda telah diklaim oleh organisasi
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Koordinasikan dengan organisasi untuk proses penyerahan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Suggested Organizations -->
            @if($suggestedOrganizations->count() > 0)
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2 sm:mb-0">
                                🎯 Organisasi yang Mungkin Tertarik</h3>
                            <a href="{{ route('donatur.cari-bantuan') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua</a>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Berdasarkan kategori donasi Anda sebelumnya</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($suggestedOrganizations as $org)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition-colors">
                                    <h4 class="font-medium text-gray-900 text-sm">{{ $org->organization_name }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($org->description, 80) }}</p>
                                    <div class="mt-2">
                                        @if($org->needs_list && is_array($org->needs_list))
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(array_slice($org->needs_list, 0, 3) as $need)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        {{ $need }}
                                                    </span>
                                                @endforeach
                                                @if(count($org->needs_list) > 3)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                        +{{ count($org->needs_list) - 3 }} lagi
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('donatur.organization.show', $org) }}" 
                                           class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                                            Lihat Detail →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tips Section -->
            <div
                class="bg-gradient-to-r from-green-50 to-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <h3 class="text-sm sm:text-lg font-medium text-gray-100">💡 Tips untuk
                                Donasi yang Lebih Baik</h3>
                            <div class="mt-2 text-xs sm:text-sm text-gray-600">
                                <ul class="space-y-1 list-disc list-inside">
                                    <li>Ambil foto yang jelas dari barang Anda</li>
                                    <li>Berikan deskripsi yang detail</li>
                                    <li>Tentukan preferensi pengambilan atau pengiriman</li>
                                    <li>Respon dengan cepat kepada organisasi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>