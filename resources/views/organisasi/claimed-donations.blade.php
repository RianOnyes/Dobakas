<x-dashboard-layout>
    <x-slot name="header">Donasi Diklaim</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Header -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Donasi Diklaim</h3>
                    <p class="text-gray-600">Kelola donasi yang telah Anda klaim dan pantau statusnya.</p>
                </div>
            </div>

            <!-- Status Filter Tabs -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 ">Filter Status</h3>
                        <div class="text-sm text-gray-500">
                            Total: {{ $donations->total() }} donasi
                        </div>
                    </div>
                    
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <a href="{{ route('organisasi.claimed-donations') }}" 
                               class="@if(!$status) border-berkah-teal text-berkah-teal @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                Semua
                            </a>
                            <a href="{{ route('organisasi.claimed-donations', ['status' => 'claimed']) }}" 
                               class="@if($status === 'claimed') border-berkah-teal text-berkah-teal @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                Diklaim
                            </a>
                            <a href="{{ route('organisasi.claimed-donations', ['status' => 'completed']) }}" 
                                class="@if($status === 'completed') border-berkah-teal text-berkah-teal @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                Selesai
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Results Info -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $donations->count() }} dari {{ $donations->total() }} donasi
                    @if($status)
                        dengan status {{ $status === 'claimed' ? 'dalam proses' : 'selesai' }}
                    @endif
                </div>
                
                <a href="{{ route('organisasi.warehouse-donations') }}" class="text-sm text-berkah-teal hover:text-berkah-hijau-gelap">
                    Jelajahi Donasi Lainnya →
                </a>
            </div>

            <!-- Donations Grid -->
            @if($donations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($donations as $donation)
                        <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                            <!-- Image -->
                            @if($donation->photos && count($donation->photos) > 0)
                                <img 
                                    src="{{ asset('storage/' . $donation->photos[0]) }}" 
                                    alt="{{ $donation->title }}"
                                    class="w-full h-48 object-cover"
                                >
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-6">
                                <!-- Status and Category -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->getStatusBadgeClass() }}">
                                        {{ $donation->getStatusLabel() }}
                                    </span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                        {{ $donation->category }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $donation->title }}
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $donation->description ?: 'Tidak ada deskripsi.' }}
                                </p>

                                <!-- Donatur Info -->
                                <div class="flex items-center mb-4">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">
                                        Donatur: {{ $donation->user->name ?? 'Unknown' }}
                                    </span>
                                </div>

                                <!-- Claimed Date -->
                                <div class="text-xs text-gray-500 mb-4">
                                    Diklaim {{ $donation->updated_at->diffForHumans() }}
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    @if($donation->status === 'claimed')
                                        <form method="POST" action="{{ route('organisasi.donation.complete', $donation) }}" class="flex-1" id="completeForm{{ $donation->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <button 
                                                type="button" 
                                                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm"
                                                onclick="showModal('completeModal{{ $donation->id }}', document.getElementById('completeForm{{ $donation->id }}'))"
                                            >
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex-1 px-4 py-2 bg-gray-100 text-gray-500 rounded-md text-center text-sm">
                                            Donasi Selesai
                                        </div>
                                    @endif
                                    
                                    <!-- Contact Donatur (if available) -->
                                    @if($donation->user && $donation->user->email)
                                        <a 
                                            href="mailto:{{ $donation->user->email }}?subject=Koordinasi Pengambilan Donasi: {{ $donation->title }}" 
                                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-sm"
                                            title="Hubungi donatur via email"
                                        >
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.25a1 1 0 00.22 0L19 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>

                                <!-- Pickup Information -->
                                @if($donation->pickup_preference && $donation->location)
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <div class="flex items-start">
                                            <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <div class="text-xs text-gray-600">
                                                <div class="font-medium">{{ $donation->pickup_preference === 'self_deliver' ? 'Donatur akan mengantar' : 'Perlu dijemput' }}</div>
                                                @if($donation->location)
                                                    <div class="mt-1">{{ $donation->location }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($donations->hasPages())
                    <div class="mt-6">
                        {{ $donations->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 ">Belum ada donasi diklaim</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($status)
                                Tidak ada donasi dengan status {{ $status === 'claimed' ? 'dalam proses' : 'selesai' }}.
                            @else
                                Anda belum mengklaim donasi apapun. Mulai jelajahi donasi yang tersedia.
                            @endif
                        </p>
                        <div class="mt-6">
                            <a 
                                href="{{ route('organisasi.warehouse-donations') }}" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-hijau-gelap"
                            >
                                Jelajahi Donasi
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Confirmation Modals for Each Donation -->
            @foreach($donations as $donation)
                @if($donation->status === 'claimed')
                    <x-confirmation-modal 
                        id="completeModal{{ $donation->id }}"
                        title="Konfirmasi Penyelesaian"
                        message="Apakah donasi '{{ $donation->title }}' sudah selesai diambil dan diterima? Pastikan donasi sudah benar-benar diterima oleh organisasi Anda."
                        confirmText="Ya, Donasi Selesai"
                        cancelText="Batal"
                        confirmClass="bg-green-600 hover:bg-green-700"
                    />
                @endif
            @endforeach
        </div>
    </div>

    <script>
        function showModal(modalId, form) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                modal.dataset.form = form.id;
            }
        }

        // Handle modal confirmations
        document.addEventListener('click', function (e) {
            if (e.target.matches('[data-action="confirm"]')) {
                const modal = e.target.closest('.modal');
                const formId = modal?.dataset.form;
                if (formId) {
                    document.getElementById(formId).submit();
                }
            } else if (e.target.matches('[data-action="cancel"]') || e.target.matches('.modal-overlay')) {
                const modal = e.target.closest('.modal') || e.target;
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal[style*="flex"]');
                modals.forEach(modal => {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                });
            }
        });
    </script>
</x-dashboard-layout> 
