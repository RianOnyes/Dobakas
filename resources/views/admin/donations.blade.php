<x-dashboard-layout>
    <x-slot name="header">Kelola Donasi</x-slot>

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

            <!-- Filters and Search -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.donations') }}" class="flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="flex-1">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}"
                                placeholder="Cari judul, kategori, atau nama donatur..." 
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                            >
                        </div>

                        <!-- Status Filter -->
                        <div class="sm:w-40">
                            <select 
                                name="status" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                            >
                                <option value="">Semua Status</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="claimed" {{ $status === 'claimed' ? 'selected' : '' }}>Claimed</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-berkah-teal text-white rounded-md hover:bg-berkah-teal-gelap transition-colors focus:outline-none focus:ring-2 focus:ring-berkah-teal focus:ring-offset-2"
                        >
                            Cari
                        </button>

                        <!-- Reset Filter -->
                        @if($search || $status)
                        <a 
                            href="{{ route('admin.donations') }}" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors"
                        >
                            Reset
                        </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="text-2xl font-bold text-yellow-600">{{ $donations->where('status', 'pending')->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Pending</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="text-2xl font-bold text-green-600">{{ $donations->where('status', 'available')->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Available</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="text-2xl font-bold text-blue-600">{{ $donations->where('status', 'claimed')->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Claimed</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="text-2xl font-bold text-indigo-600">{{ $donations->where('status', 'completed')->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Completed</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="text-2xl font-bold text-red-600">{{ $donations->where('status', 'cancelled')->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Cancelled</div>
                </div>
            </div>

            <!-- Donations Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Donasi</h3>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Total: {{ $donations->total() }} donasi
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Donasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Donatur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($donations as $donation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($donation->photos && count($donation->photos) > 0)
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/' . $donation->photos[0]) }}" alt="">
                                            </div>
                                            @else
                                            <div class="flex-shrink-0 h-12 w-12 bg-gray-300 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $donation->title }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ Str::limit($donation->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $donation->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-300">{{ $donation->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $donation->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->getStatusBadgeClass() }}">
                                            {{ $donation->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $donation->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-col space-y-2">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.donations.show', $donation) }}" 
                                               class="inline-flex items-center justify-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                                Lihat Detail
                                            </a>

                                            <!-- Status Update Buttons -->
                                            @if($donation->status === 'pending')
                                            <form method="POST" action="{{ route('admin.donations.status', $donation) }}" class="inline" id="approveForm{{ $donation->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="available">
                                                <button type="button" 
                                                        onclick="showModal('approveModal{{ $donation->id }}', document.getElementById('approveForm{{ $donation->id }}'))"
                                                        class="w-full inline-flex items-center justify-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                                    Setujui
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.donations.status', $donation) }}" class="inline" id="rejectForm{{ $donation->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="button" 
                                                        onclick="showModal('rejectModal{{ $donation->id }}', document.getElementById('rejectForm{{ $donation->id }}'))"
                                                        class="w-full inline-flex items-center justify-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                                                    Tolak
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada donasi ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($donations->hasPages())
                    <div class="mt-6">
                        {{ $donations->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modals for donation status changes -->
    @foreach($donations as $donation)
        @if($donation->status === 'pending')
            <!-- Approve Modal -->
            <x-confirmation-modal 
                id="approveModal{{ $donation->id }}"
                title="Setujui Donasi"
                message="Apakah Anda yakin ingin menyetujui donasi '{{ $donation->title }}'? Donasi akan tersedia untuk diklaim oleh organisasi."
                confirmText="Ya, Setujui"
                cancelText="Batal"
                confirmClass="bg-green-600 hover:bg-green-700" />

            <!-- Reject Modal -->
            <x-confirmation-modal 
                id="rejectModal{{ $donation->id }}"
                title="Tolak Donasi"
                message="Apakah Anda yakin ingin menolak donasi '{{ $donation->title }}'? Donasi akan dibatalkan dan tidak dapat dikembalikan."
                confirmText="Ya, Tolak"
                cancelText="Batal"
                confirmClass="bg-red-600 hover:bg-red-700" />
        @endif
    @endforeach
</x-dashboard-layout> 