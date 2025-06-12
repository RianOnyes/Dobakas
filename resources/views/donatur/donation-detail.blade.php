<x-dashboard-layout>
    <x-slot name="header">Detail Donasi</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-700 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative dark:bg-red-900 dark:border-red-700 dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('donatur.donasi-saya') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Donasi Saya
                </a>
            </div>

            <!-- Donation Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $donation->title }}
                            </h1>
                            <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->status_badge_color }}">
                                    {{ $donation->status_label }}
                                </span>
                                <span>{{ $donation->category }}</span>
                                <span>Dibuat {{ $donation->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            @if(in_array($donation->status, ['pending', 'available']))
                                <form action="{{ route('donatur.donation.cancel', $donation) }}" method="POST" class="inline" id="cancelFormDetail">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" 
                                            onclick="showModal('cancelModalDetail', document.getElementById('cancelFormDetail'))"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                        Batalkan Donasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Photos -->
                    @if($donation->photos && count($donation->photos) > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Foto Barang</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($donation->photos as $photo)
                                        <div class="aspect-w-16 aspect-h-12">
                                            <img src="{{ asset('storage/' . $photo) }}" 
                                                 alt="{{ $donation->title }}"
                                                 class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                                 onclick="openModal('{{ asset('storage/' . $photo) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    @if($donation->description)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Deskripsi Barang</h3>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-wrap">{{ $donation->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Status Timeline -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Status Timeline</h3>
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <!-- Created -->
                                    <li>
                                        <div class="relative pb-8">
                                            <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600"></div>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <p class="text-sm text-gray-900 dark:text-gray-100 font-medium">Donasi dibuat</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $donation->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Current Status -->
                                    @if($donation->status !== 'pending')
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!in_array($donation->status, ['completed', 'cancelled']))
                                                    <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600"></div>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full 
                                                            @if($donation->status === 'available') bg-blue-500
                                                            @elseif($donation->status === 'claimed') bg-indigo-500
                                                            @elseif($donation->status === 'completed') bg-green-500
                                                            @elseif($donation->status === 'cancelled') bg-red-500
                                                            @endif 
                                                            flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            @if($donation->status === 'available')
                                                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                            @elseif($donation->status === 'claimed')
                                                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                            @elseif($donation->status === 'completed')
                                                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                            @elseif($donation->status === 'cancelled')
                                                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5">
                                                        <p class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $donation->status_label }}</p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $donation->updated_at->format('d M Y, H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Donation Details -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detail Donasi</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Kategori</p>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $donation->category }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Status</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->status_badge_color }}">
                                        {{ $donation->status_label }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Preferensi Pengambilan</p>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $donation->pickup_preference_label }}</p>
                                </div>

                                @if($donation->location)
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Lokasi</p>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $donation->location }}</p>
                                    </div>
                                @endif

                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Tanggal Dibuat</p>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $donation->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                @if($donation->updated_at != $donation->created_at)
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Terakhir Diperbarui</p>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $donation->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Organization Info (if claimed) -->
                    @if($donation->claimedByOrganization)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Diklaim Oleh</h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Nama Organisasi</p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            {{ $donation->claimedByOrganization->organizationDetail->organization_name ?? $donation->claimedByOrganization->name }}
                                        </p>
                                    </div>

                                    @if($donation->claimedByOrganization->organizationDetail)
                                        @if($donation->claimedByOrganization->organizationDetail->contact_person)
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Contact Person</p>
                                                <p class="text-gray-600 dark:text-gray-400">{{ $donation->claimedByOrganization->organizationDetail->contact_person }}</p>
                                            </div>
                                        @endif

                                        @if($donation->claimedByOrganization->organizationDetail->contact_phone)
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Telepon</p>
                                                <p class="text-gray-600 dark:text-gray-400">{{ $donation->claimedByOrganization->organizationDetail->contact_phone }}</p>
                                            </div>
                                        @endif
                                    @endif

                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Email</p>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $donation->claimedByOrganization->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for cancellation -->
    @if(in_array($donation->status, ['pending', 'available']))
        <x-confirmation-modal 
            id="cancelModalDetail"
            title="Batalkan Donasi"
            message="Apakah Anda yakin ingin membatalkan donasi '{{ $donation->title }}'? Tindakan ini tidak dapat dibatalkan dan donasi akan dihapus dari sistem."
            confirmText="Ya, Batalkan Donasi"
            cancelText="Tidak, Tetap Simpan"
            confirmClass="bg-red-600 hover:bg-red-700" />
    @endif

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition-opacity">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-dashboard-layout> 