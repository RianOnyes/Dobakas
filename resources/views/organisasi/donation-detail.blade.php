<x-dashboard-layout>
    <x-slot name="header">Detail Donasi</x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('organisasi.warehouse-donations') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Gudang Admin
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Images -->
                    @if($donation->photos && count($donation->photos) > 0)
                        <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Donasi</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($donation->photos as $index => $photo)
                                        <div class="relative">
                                            <img 
                                                src="{{ asset('storage/' . $photo) }}" 
                                                alt="Foto donasi {{ $index + 1 }}"
                                                class="w-full h-64 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                                onclick="showImageModal('{{ asset('storage/' . $photo) }}', '{{ $donation->title }}')"
                                            >
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Donation Details -->
                    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <!-- Status Badge -->
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Tersedia untuk Diklaim
                                </span>
                            </div>

                            <!-- Title and Category -->
                            <div class="mb-6">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $donation->title }}</h1>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ $donation->category }}
                                </span>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Deskripsi</h3>
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $donation->description ?: 'Tidak ada deskripsi tambahan untuk donasi ini.' }}
                                </p>
                            </div>

                            <!-- Pickup Information -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengambilan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Preferensi Pengambilan</label>
                                        <div class="flex items-center">
                                            @if($donation->pickup_preference === 'self_deliver')
                                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span class="text-gray-900 ">Donatur akan mengantar sendiri</span>
                                            @else
                                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="text-gray-900 ">Perlu dijemput</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($donation->location)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500 mb-1">Lokasi</label>
                                            <p class="text-gray-900 ">{{ $donation->location }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Donatur Information -->
                    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Donatur</h3>
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-lg font-medium text-gray-700">
                                        {{ substr($donation->user->name ?? 'U', 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900 ">{{ $donation->user->name ?? 'Unknown User' }}</h4>
                                    <p class="text-sm text-gray-500">Donatur</p>
                                </div>
                            </div>

                            <!-- Contact Donatur -->
                            @if($donation->user && $donation->user->email)
                                <a 
                                    href="mailto:{{ $donation->user->email }}?subject=Koordinasi Pengambilan Donasi: {{ $donation->title }}&body=Halo {{ $donation->user->name }}, saya tertarik dengan donasi '{{ $donation->title }}' yang Anda posting. Mohon koordinasi untuk pengambilan donasi ini. Terima kasih." 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-slate-100 hover:bg-gray-50"
                                >
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.25a1 1 0 00.22 0L19 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Hubungi Donatur
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Donation Meta -->
                    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Donasi</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Diposting:</span>
                                    <span class="text-sm text-gray-900 ">{{ $donation->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Kategori:</span>
                                    <span class="text-sm text-gray-900 ">{{ $donation->category }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Status:</span>
                                    <span class="text-sm text-green-600 font-medium">Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Claim Action -->
                    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Klaim Donasi</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                Dengan mengklaim donasi ini, Anda berkomitmen untuk mengambil dan menggunakan donasi sesuai dengan tujuan organisasi.
                            </p>
                            
                            <form method="POST" action="{{ route('organisasi.donation.claim', $donation) }}" id="claimDetailForm">
                                @csrf
                                @method('PATCH')
                                <button 
                                    type="button" 
                                    class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-hijau-gelap transition-colors"
                                    onclick="showModal('claimDetailModal', document.getElementById('claimDetailForm'))"
                                >
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Klaim Donasi Ini
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <x-confirmation-modal 
        id="claimDetailModal"
        title="Konfirmasi Klaim Donasi"
        message="Apakah Anda yakin ingin mengklaim donasi '{{ $donation->title }}'? Pastikan organisasi Anda membutuhkan dan dapat menggunakan donasi ini dengan baik."
        confirmText="Ya, Klaim Donasi"
        cancelText="Batal"
        confirmClass="bg-berkah-teal hover:bg-berkah-hijau-gelap"
    />

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-slate-100">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 " id="modalTitle">Foto Donasi</h3>
                    <button 
                        onclick="closeImageModal()" 
                        class="text-gray-400 hover:text-gray-600"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg">
            </div>
        </div>
    </div>

    <script>
        // Image modal functions
        function showImageModal(imageSrc, title) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target === document.getElementById('imageModal')) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-dashboard-layout> 
