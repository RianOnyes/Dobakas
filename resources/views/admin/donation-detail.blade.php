<x-dashboard-layout>
    <x-slot name="header">Detail Donasi</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.donations') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Donasi
                </a>
            </div>

            <!-- Donation Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $donation->title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $donation->description }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Donasi</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $donation->category }}
                                    </span>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $donation->getStatusBadgeClass() }}">
                                        {{ $donation->getStatusLabel() }}
                                    </span>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Dibuat</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $donation->created_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Donatur</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $donation->user->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $donation->user->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Verifikasi</label>
                                    @if($donation->user->is_verified)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Belum Verifikasi
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Photos -->
                    @if($donation->photos && count($donation->photos) > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Foto Barang</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($donation->photos as $photo)
                                    <div class="aspect-w-16 aspect-h-12">
                                        <img src="{{ asset('storage/' . $photo) }}" 
                                             alt="{{ $donation->title }}"
                                             class="w-full h-48 object-cover rounded-lg">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Admin Actions -->
                    @if($donation->status === 'pending')
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi Admin</h3>
                            <div class="flex space-x-4">
                                <form method="POST" action="{{ route('admin.donations.status', $donation) }}" class="inline" id="approveForm">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="available">
                                    <button type="button" 
                                            onclick="showModal('approveModal', document.getElementById('approveForm'))"
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                        Setujui Donasi
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.donations.status', $donation) }}" class="inline" id="rejectForm">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="button" 
                                            onclick="showModal('rejectModal', document.getElementById('rejectForm'))"
                                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                        Tolak Donasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modals -->
    @if($donation->status === 'pending')
        <x-confirmation-modal 
            id="approveModal"
            title="Setujui Donasi"
            message="Apakah Anda yakin ingin menyetujui donasi '{{ $donation->title }}'? Donasi akan tersedia untuk diklaim oleh organisasi."
            confirmText="Ya, Setujui"
            cancelText="Batal"
            confirmClass="bg-green-600 hover:bg-green-700" />

        <x-confirmation-modal 
            id="rejectModal"
            title="Tolak Donasi"
            message="Apakah Anda yakin ingin menolak donasi '{{ $donation->title }}'? Donasi akan dibatalkan dan tidak dapat dikembalikan."
            confirmText="Ya, Tolak"
            cancelText="Batal"
            confirmClass="bg-red-600 hover:bg-red-700" />
    @endif
</x-dashboard-layout>
