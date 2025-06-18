<x-dashboard-layout>
    <x-slot name="header">Riwayat Donasi</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Riwayat</h3>
                    <p class="text-gray-600">Lihat riwayat donasi yang telah selesai atau dibatalkan.</p>
                </div>
            </div>

            <!-- Donations History -->
            @if($donations->count() > 0)
                <div class="space-y-6 mb-6">
                    @foreach($donations as $donation)
                        <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                    <!-- Donation Info -->
                                    <div class="flex-1">
                                        <div class="flex items-start space-x-4">
                                            <!-- Image -->
                                            <div class="flex-shrink-0">
                                                @if($donation->photos && count($donation->photos) > 0)
                                                    <img src="{{ asset('storage/' . $donation->photos[0]) }}" 
                                                         alt="{{ $donation->title }}"
                                                         class="w-20 h-20 object-cover rounded-lg">
                                                @else
                                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Details -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="text-lg font-semibold text-gray-900 truncate">
                                                        {{ $donation->title }}
                                                    </h4>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->status_badge_color }}">
                                                        {{ $donation->status_label }}
                                                    </span>
                                                </div>

                                                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                                                    <span class="flex items-center">
                                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                        </svg>
                                                        {{ $donation->category }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        {{ $donation->pickup_preference_label }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $donation->created_at->format('d M Y') }}
                                                    </span>
                                                </div>

                                                @if($donation->description)
                                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                                        {{ Str::limit($donation->description, 150) }}
                                                    </p>
                                                @endif

                                                <!-- Organization Info (if claimed and completed) -->
                                                @if($donation->claimedByOrganization && $donation->status === 'completed')
                                                    <div class="bg-green-50 rounded-lg p-3">
                                                        <div class="flex items-center">
                                                            <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            <div>
                                                                <p class="text-sm font-medium text-green-900">
                                                                    Berhasil disalurkan ke:
                                                                </p>
                                                                <p class="text-sm text-green-700">
                                                                    {{ $donation->claimedByOrganization->organizationDetail->organization_name ?? $donation->claimedByOrganization->name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($donation->status === 'cancelled')
                                                    <div class="bg-red-50 rounded-lg p-3">
                                                        <div class="flex items-center">
                                                            <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            <p class="text-sm text-red-700">
                                                                Donasi dibatalkan pada {{ $donation->updated_at->format('d M Y, H:i') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4 lg:mt-0 lg:ml-6 flex-shrink-0">
                                        <a href="{{ route('donatur.donation.show', $donation) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        {{ $donations->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 ">Belum ada riwayat donasi</h3>
                        <p class="mt-2 text-gray-600">
                            Anda belum memiliki donasi yang selesai atau dibatalkan.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('donatur.buat-donasi') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Donasi Baru
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout> 
