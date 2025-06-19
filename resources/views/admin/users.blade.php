<x-dashboard-layout>
    <x-slot name="header">Kelola Pengguna</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Page Header -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kelola Pengguna</h3>
                    <p class="text-gray-600 dark:text-gray-400">Kelola akun pengguna, verifikasi, dan hak akses di
                        platform.</p>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 ">All Users</h3>
                        <div class="text-sm text-gray-500">
                            Total: {{ $users->total() }} users
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-berkah-cream/30">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Joined</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 ">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 ">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            @if($user->role === 'admin') bg-red-100 text-red-800 
                                                            @elseif($user->role === 'donatur') bg-green-100 text-green-800 
                                                            @else bg-purple-100 text-purple-800 @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $user->is_verified ? 'Verified' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                @if(!$user->is_verified)
                                                    <form method="POST" action="{{ route('admin.users.verify', $user) }}"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                                            Verifikasi
                                                        </button>
                                                    </form>
                                                @endif

                                                @if(!$user->isAdmin())
                                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}"
                                                        class="inline" id="deleteUserForm{{ $user->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="showModal('deleteUserModal{{ $user->id }}', document.getElementById('deleteUserForm{{ $user->id }}'))"
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modals for user deletion -->
    @foreach($users as $user)
        @if(!$user->isAdmin())
            <x-confirmation-modal id="deleteUserModal{{ $user->id }}" title="Hapus Pengguna"
                message="Apakah Anda yakin ingin menghapus pengguna '{{ $user->name }}'? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data yang terkait."
                confirmText="Ya, Hapus Pengguna" cancelText="Batal" confirmClass="bg-red-600 hover:bg-red-700" />
        @endif
    @endforeach

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