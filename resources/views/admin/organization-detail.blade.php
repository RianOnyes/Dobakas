<x-dashboard-layout>
    <x-slot name="header">Detail Organisasi</x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.organizations') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Organisasi
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Organization Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start space-x-6">
                                <div class="flex-shrink-0">
                                    @if($organization->logo)
                                    <img class="h-24 w-24 rounded-lg object-cover" src="{{ asset('storage/' . $organization->logo) }}" alt="">
                                    @else
                                    <div class="h-24 w-24 bg-gray-300 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                        <span class="text-2xl font-medium text-gray-700 dark:text-gray-300">
                                            {{ substr($organization->organization_name, 0, 2) }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $organization->organization_name }}</h3>
                                        @if($organization->user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Terverifikasi
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Belum Terverifikasi
                                        </span>
                                        @endif
                                    </div>
                                    <p class="mt-2 text-gray-500 dark:text-gray-400">{{ $organization->description }}</p>
                                    
                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Alamat</h4>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $organization->address }}</p>
                                        </div>
                                        @if($organization->phone)
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Telepon</h4>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $organization->phone }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    @if($organization->website)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Website</h4>
                                        <a href="{{ $organization->website }}" target="_blank" class="mt-1 text-sm text-berkah-teal hover:text-berkah-teal-gelap">
                                            {{ $organization->website }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Needs List -->
                    @if($organization->needs_list && count($organization->needs_list) > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Kebutuhan Organisasi</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($organization->needs_list as $need)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-berkah-mint text-berkah-teal-gelap">
                                    {{ $need }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Contact Person -->
                    @if($organization->contact_person)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Kontak Person</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Nama:</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">{{ $organization->contact_person }}</span>
                                </div>
                                @if($organization->contact_phone)
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Telepon:</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">{{ $organization->contact_phone }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Recent Donations -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Donasi yang Diterima</h3>
                            @if($claimedDonations->count() > 0)
                            <div class="space-y-4">
                                @foreach($claimedDonations as $donation)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        @if($donation->photos && count($donation->photos) > 0)
                                                                                        <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/' . $donation->photos[0]) }}" alt="">
                                        @else
                                        <div class="h-12 w-12 bg-gray-300 dark:bg-gray-600 rounded-lg"></div>
                                        @endif
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $donation->title }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">dari {{ $donation->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->getStatusBadgeClass() }}">
                                            {{ $donation->getStatusLabel() }}
                                        </span>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $donation->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                Belum ada donasi yang diterima
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Account Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Akun</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Email:</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $organization->user->email }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Nama Pengguna:</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $organization->user->name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Bergabung:</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $organization->user->created_at->format('d F Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Terakhir Aktif:</span>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $organization->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Statistik</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Donasi Diterima:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $claimedDonations->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Donasi Selesai:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $claimedDonations->where('status', 'completed')->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Dalam Proses:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $claimedDonations->where('status', 'claimed')->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Aksi Cepat</h3>
                            
                            <div class="space-y-3">
                                @if(!$organization->user->email_verified_at)
                                <form method="POST" action="{{ route('admin.users.verify', $organization->user) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button 
                                        type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150"
                                    >
                                        Verifikasi Organisasi
                                    </button>
                                </form>
                                @endif

                                <form method="POST" action="{{ route('admin.users.delete', $organization->user) }}" class="w-full" id="deleteOrgDetailForm">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="button" 
                                        onclick="showModal('deleteOrgDetailModal', document.getElementById('deleteOrgDetailForm'))"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150"
                                    >
                                        Hapus Organisasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for organization deletion -->
    <x-confirmation-modal 
        id="deleteOrgDetailModal"
        title="Hapus Organisasi"
        message="Apakah Anda yakin ingin menghapus organisasi '{{ $organization->organization_name }}'? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data yang terkait termasuk riwayat donasi."
        confirmText="Ya, Hapus Organisasi"
        cancelText="Batal"
        confirmClass="bg-red-600 hover:bg-red-700" />
</x-dashboard-layout> 