<x-dashboard-layout>
    <x-slot name="header">Dasbor Admin</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <x-dashboard.stat-card title="Total Pengguna" :value="$stats['total_users']" icon="users" />

                <x-dashboard.stat-card title="Donatur" :value="$stats['total_donatur']" icon="donations" />

                <x-dashboard.stat-card title="Organisasi" :value="$stats['total_organisasi']" icon="organizations" />

                <x-dashboard.stat-card title="Menunggu Verifikasi" :value="$stats['pending_verification']"
                    icon="pending" />
            </div>

            <!-- Recent Users -->
            <div class="bg-slate-100 overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
                <div class="p-3 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2 sm:mb-0">
                            Pengguna Terbaru</h3>
                        <a href="{{ route('admin.users') }}"
                            class="text-sm text-berkah-secondary hover:text-berkah-primary transition-colors">Lihat
                            Semua</a>
                    </div>

                    <!-- Mobile view (cards) -->
                    <div class="block sm:hidden space-y-3">
                        @foreach($recent_users as $user)
                            <div class="bg-berkah-cream/50 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($user->role === 'admin') bg-berkah-primary text-white
                                                    @elseif($user->role === 'donatur') bg-berkah-secondary text-white
                                                    @else bg-berkah-accent text-berkah-primary @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mb-2">{{ $user->email }}</p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_verified ? 'bg-berkah-secondary text-white' : 'bg-yellow-100 text-yellow-800  ' }}">
                                        {{ $user->is_verified ? 'Terverifikasi' : 'Menunggu' }}
                                    </span>
                                    <span
                                        class="text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop view (table) -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-berkah-accent/20">
                            <thead class="bg-berkah-cream/30">
                                <tr>
                                    <th
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bergabung</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-berkah-accent/10">
                                @foreach($recent_users as $user)
                                    <tr class="hover:bg-berkah-cream/30 transition-colors">
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            @if($user->role === 'admin') bg-berkah-primary text-white
                                                            @elseif($user->role === 'donatur') bg-berkah-secondary text-white
                                                            @else bg-berkah-accent text-berkah-primary @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_verified ? 'bg-berkah-secondary text-white' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $user->is_verified ? 'Terverifikasi' : 'Menunggu' }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>