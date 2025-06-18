<x-dashboard-layout>
    <x-slot name="header">Kelola Organisasi</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Page Header -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kelola Organisasi</h3>
                    <p class="text-gray-600">Kelola akun organisasi, verifikasi, dan status keanggotaan.</p>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.organizations') }}" class="flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="flex-1">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}"
                                placeholder="Cari nama organisasi, deskripsi, atau email..." 
                                class="w-full bg-slate-200 rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                            >
                        </div>

                        <!-- Status Filter -->
                        <div class="sm:w-40">
                            <select 
                                name="status" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                            >
                                <option value="">Semua Status</option>
                                <option value="verified" {{ $status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="unverified" {{ $status === 'unverified' ? 'selected' : '' }}>Belum Terverifikasi</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-berkah-teal text-white rounded-md hover:bg-berkah-teal-gelap transition-colors"
                        >
                            Cari
                        </button>

                        <!-- Reset Filter -->
                        @if($search || $status)
                        <a 
                            href="{{ route('admin.organizations') }}" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors"
                        >
                            Reset
                        </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Organizations Table -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 ">Daftar Organisasi</h3>
                        <div class="text-sm text-gray-500">
                            Total: {{ $organizationUsers->total() }} organisasi
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-berkah-cream/30">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-gray-200">
                                @forelse($organizationUsers as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if($user->organizationDetail && $user->organizationDetail->logo)
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/' . $user->organizationDetail->logo) }}" alt="">
                                                @else
                                                <div class="h-12 w-12 bg-gray-300 rounded-lg flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700">
                                                        {{ substr($user->organizationDetail ? $user->organizationDetail->organization_name : $user->name, 0, 2) }}
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 ">
                                                    {{ $user->organizationDetail ? $user->organizationDetail->organization_name : $user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    @if($user->organizationDetail && $user->organizationDetail->description)
                                                        {{ Str::limit($user->organizationDetail->description, 50) }}
                                                    @else
                                                        <span class="italic">Profil organisasi belum lengkap</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 ">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        @if($user->organizationDetail && $user->organizationDetail->contact_phone)
                                        <div class="text-sm text-gray-900 ">
                                            {{ $user->organizationDetail->contact_phone }}
                                        </div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 ">
                                            @if($user->organizationDetail && $user->organizationDetail->organization_address)
                                                {{ $user->organizationDetail->organization_address }}
                                            @else
                                                <span class="italic text-gray-400">Alamat belum diisi</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Terverifikasi
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            Belum Terverifikasi
                                        </span>
                                        @endif
                                        
                                        @if(!$user->organizationDetail)
                                        <br>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 mt-1">
                                            Profil Belum Lengkap
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-col space-y-1">
                                            <!-- View Button -->
                                            @if($user->organizationDetail)
                                            <a href="{{ route('admin.organizations.show', $user->organizationDetail) }}" 
                                               class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-teal-gelap focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-berkah-teal transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat Detail
                                            </a>
                                            @else
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-400 bg-gray-50 cursor-not-allowed">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat Detail
                                            </span>
                                            @endif

                                            <!-- Verify User -->
                                            @if(!$user->email_verified_at)
                                            <form method="POST" action="{{ route('admin.users.verify', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Verifikasi
                                                </button>
                                            </form>
                                            @endif

                                            <!-- Delete User -->
                                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" id="deleteOrgForm{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="showModal('deleteOrgModal{{ $user->id }}', document.getElementById('deleteOrgForm{{ $user->id }}'))"
                                                        class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Tidak ada organisasi ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($organizationUsers->hasPages())
                    <div class="mt-6">
                        {{ $organizationUsers->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modals for organization deletion -->
    @foreach($organizationUsers as $user)
                    <x-confirmation-modal 
                id="deleteOrgModal{{ $user->id }}"
                title="Hapus Organisasi"
                message="Apakah Anda yakin ingin menghapus organisasi '{{ $user->organizationDetail ? $user->organizationDetail->organization_name : $user->name }}'? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data yang terkait."
                confirmText="Ya, Hapus Organisasi"
                cancelText="Batal"
                confirmClass="bg-red-600 hover:bg-red-700" />
    @endforeach
</x-dashboard-layout> 
