<x-dashboard-layout>
    <x-slot name="header">Kelola Donasi</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kelola Donasi</h3>
                    <p class="text-gray-600">Kelola semua donasi yang masuk dan ubah status sesuai kebutuhan.</p>
                </div>
            </div>

            <!-- Filter and Search -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.donations') }}" class="flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Cari judul, kategori, atau nama donatur..."
                                class="w-full rounded-md bg-slate-200 border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal">
                        </div>

                        <!-- Status Filter -->
                        <div class="sm:w-40">
                            <select name="status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Available
                                </option>
                                <option value="claimed" {{ $status === 'claimed' ? 'selected' : '' }}>Claimed</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <button type="submit"
                            class="px-4 py-2 bg-berkah-teal text-white rounded-md hover:bg-berkah-teal-gelap transition-colors">
                            Cari
                        </button>

                        <!-- Reset Filter -->
                        @if($search || $status)
                            <a href="{{ route('admin.donations') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Donations Table -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Donasi</h3>
                        <div class="text-sm text-gray-500">
                            Total: {{ $donations->total() }} donasi
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-berkah-cream/30">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Donasi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Donatur</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-gray-200">
                                @forelse($donations as $donation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    @if($donation->photos && count($donation->photos) > 0)
                                                        <img class="h-12 w-12 rounded-lg object-cover"
                                                            src="{{ asset('storage/' . $donation->photos[0]) }}" alt="">
                                                    @else
                                                        <div
                                                            class="h-12 w-12 bg-gray-300 rounded-lg flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $donation->title }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ Str::limit($donation->description, 50) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $donation->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $donation->user->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $donation->category }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->getStatusBadgeClass() }}">
                                                {{ $donation->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $donation->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col space-y-1">
                                                <!-- View Button -->
                                                <a href="{{ route('admin.donations.show', $donation) }}"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-teal-gelap transition-colors">
                                                    Lihat Detail
                                                </a>

                                                <!-- Status Update -->
                                                @if($donation->status === 'pending')
                                                    <form method="POST"
                                                        action="{{ route('admin.donations.status', $donation) }}"
                                                        id="approveForm{{ $donation->id }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="available">
                                                        <button type="submit"
                                                            class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak ada donasi ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $donations->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>