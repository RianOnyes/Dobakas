<x-dashboard-layout>
    <x-slot name="header">Donasi Saya</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-700 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Page Header -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Donasi Saya</h3>
                    <p class="text-gray-600">Kelola dan pantau status donasi yang telah Anda buat.</p>
                </div>
            </div>

            <!-- Header with Actions -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Donasi Aktif Saya</h3>
                            <p class="text-gray-600">Kelola donasi yang sedang berlangsung dan belum selesai.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('donatur.buat-donasi') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Donasi Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="mb-6">
                <div class="sm:hidden">
                    <select class="block w-full rounded-md border-gray-300 ">
                        <option>Semua Status</option>
                        <option>Menunggu Verifikasi</option>
                        <option>Tersedia</option>
                        <option>Sudah Diklaim</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <a href="{{ route('donatur.donasi-saya') }}" 
                           class="@if(!request('status')) border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Semua ({{ $donations->total() }})
                        </a>
                        <a href="{{ route('donatur.donasi-saya', ['status' => 'pending']) }}" 
                           class="@if(request('status') === 'pending') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Menunggu Verifikasi
                        </a>
                        <a href="{{ route('donatur.donasi-saya', ['status' => 'available']) }}" 
                           class="@if(request('status') === 'available') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Tersedia
                        </a>
                        <a href="{{ route('donatur.donasi-saya', ['status' => 'claimed']) }}" 
                           class="@if(request('status') === 'claimed') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Sudah Diklaim
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Donations Grid -->
            @if($donations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($donations as $donation)
                        <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                            <!-- Donation Image/Icon -->
                            <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                @if($donation->donation_type === 'money')
                                    <div class="w-full h-48 flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-200">
                                        <div class="text-center">
                                            <svg class="h-16 w-16 text-blue-600 dark:text-blue-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @elseif($donation->photos && count($donation->photos) > 0)
                                    <img src="{{ asset('storage/' . $donation->photos[0]) }}" 
                                         alt="{{ $donation->title }}"
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <!-- Status Badge -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->status_badge_color }}">
                                        {{ $donation->status_label }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $donation->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Title and Category -->
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $donation->title }}
                                </h4>
                                <p class="text-sm text-indigo-600 mb-3">
                                    {{ $donation->category }}
                                </p>

                                <!-- Description -->
                                @if($donation->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit($donation->description, 100) }}
                                    </p>
                                @endif

                                <!-- Donation Type Specific Info -->
                                @if($donation->donation_type === 'money')
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        {{ match($donation->payment_method) {
                                            'bank_transfer' => 'Transfer Bank',
                                            'e_wallet' => 'E-Wallet',
                                            'cash' => 'Tunai',
                                            default => 'Payment Method'
                                        } }}
                                        @if($donation->is_anonymous)
                                            <span class="ml-2 text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">Anonim</span>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $donation->pickup_preference_label }}
                                    </div>
                                @endif

                                <!-- Claimed By (if applicable) -->
                                @if($donation->claimedByOrganization)
                                    <div class="bg-blue-50 rounded-lg p-3 mb-4">
                                        <p class="text-sm font-medium text-blue-900 mb-1">
                                            Diklaim oleh:
                                        </p>
                                        <p class="text-sm text-blue-700">
                                            {{ $donation->claimedByOrganization->organizationDetail->organization_name ?? $donation->claimedByOrganization->name }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('donatur.donation.show', $donation) }}" 
                                       class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                        Lihat Detail
                                    </a>
                                    @if(in_array($donation->status, ['pending', 'available']))
                                        <form action="{{ route('donatur.donation.cancel', $donation) }}" method="POST" class="inline" id="cancelForm{{ $donation->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" 
                                                    onclick="showModal('cancelModal{{ $donation->id }}', document.getElementById('cancelForm{{ $donation->id }}'))"
                                                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        {{ $donations->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 ">Belum ada donasi</h3>
                        <p class="mt-2 text-gray-600">
                            @if(request('status'))
                                Tidak ada donasi dengan status "{{ request('status') }}" ditemukan.
                            @else
                                Anda belum memiliki donasi aktif. Mulai berbagi kebaikan dengan membuat donasi pertama Anda.
                            @endif
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('donatur.buat-donasi') }}" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Donasi Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Confirmation Modals for each donation -->
            @foreach($donations as $donation)
                @if(in_array($donation->status, ['pending', 'available']))
                    <x-confirmation-modal 
                        id="cancelModal{{ $donation->id }}"
                        title="Batalkan Donasi"
                        message="Apakah Anda yakin ingin membatalkan donasi '{{ $donation->title }}'? Tindakan ini tidak dapat dibatalkan."
                        confirmText="Ya, Batalkan"
                        cancelText="Tidak"
                        confirmClass="bg-red-600 hover:bg-red-700" />
                @endif
            @endforeach
        </div>
    </div>
</x-dashboard-layout> 
