<x-dashboard-layout>
    <x-slot name="header">Permintaan Saya</x-slot>

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
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Permintaan Saya</h3>
                            <p class="text-gray-600">Kelola permintaan donasi yang telah Anda buat.
                            </p>
                        </div>
                        <a href="{{ route('organisasi.create-request') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-teal-gelap transition-colors">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Permintaan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Filter Tabs -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <a href="{{ route('organisasi.requests') }}"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ !$status ? 'border-berkah-teal text-berkah-teal' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Semua
                        </a>
                        <a href="{{ route('organisasi.requests', ['status' => 'active']) }}"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ $status === 'active' ? 'border-berkah-teal text-berkah-teal' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Aktif
                        </a>
                        <a href="{{ route('organisasi.requests', ['status' => 'fulfilled']) }}"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ $status === 'fulfilled' ? 'border-berkah-teal text-berkah-teal' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Terpenuhi
                        </a>
                        <a href="{{ route('organisasi.requests', ['status' => 'cancelled']) }}"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ $status === 'cancelled' ? 'border-berkah-teal text-berkah-teal' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Dibatalkan
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Results Info -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $requests->count() }} dari {{ $requests->total() }} permintaan
                    @if($status)
                        dengan status
                        {{ $status === 'active' ? 'aktif' : ($status === 'fulfilled' ? 'terpenuhi' : 'dibatalkan') }}
                    @endif
                </div>
            </div>

            <!-- Requests Grid -->
            @if($requests->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($requests as $request)
                        <div
                            class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                            <div class="p-6">
                                <!-- Status and Urgency -->
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $request->getStatusBadgeClass() }}">
                                        {{ $request->getStatusLabel() }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $request->getUrgencyBadgeClass() }}">
                                        {{ $request->getUrgencyLabel() }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $request->title }}
                                </h3>

                                <!-- Category -->
                                <div class="flex items-center mb-2">
                                    <span
                                        class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                        {{ $request->category }}
                                    </span>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $request->description }}
                                </p>

                                <!-- Quantity and Location -->
                                <div class="space-y-2 mb-4">
                                    @if($request->quantity_needed)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                            Jumlah: {{ $request->quantity_needed }}
                                        </div>
                                    @endif

                                    @if($request->needed_by)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Dibutuhkan: {{ $request->getFormattedNeededBy() }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Created date -->
                                <div class="text-xs text-gray-500 mb-4">
                                    Dibuat {{ $request->created_at->diffForHumans() }}
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    @if($request->status === 'active')
                                        <form method="POST" action="{{ route('organisasi.request.status', $request) }}"
                                            class="flex-1" id="fulfillForm{{ $request->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="fulfilled">
                                            <button type="button"
                                                class="w-full px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm"
                                                onclick="showModal('fulfillModal{{ $request->id }}', document.getElementById('fulfillForm{{ $request->id }}'))">
                                                Tandai Terpenuhi
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('organisasi.request.status', $request) }}"
                                            class="flex-1" id="cancelForm{{ $request->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="button"
                                                class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm"
                                                onclick="showModal('cancelModal{{ $request->id }}', document.getElementById('cancelForm{{ $request->id }}'))">
                                                Batalkan
                                            </button>
                                        </form>
                                    @elseif($request->status === 'fulfilled')
                                        <div class="flex-1 px-3 py-2 bg-gray-100 text-gray-500 rounded-md text-center text-sm">
                                            Permintaan Terpenuhi
                                        </div>
                                    @else
                                        <form method="POST" action="{{ route('organisasi.request.status', $request) }}"
                                            class="flex-1" id="reactiveForm{{ $request->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                            <button type="button"
                                                class="w-full px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm"
                                                onclick="showModal('reactiveModal{{ $request->id }}', document.getElementById('reactiveForm{{ $request->id }}'))">
                                                Aktifkan Kembali
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('organisasi.request.delete', $request) }}"
                                        class="inline" id="deleteForm{{ $request->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="px-3 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-sm"
                                            onclick="showModal('deleteModal{{ $request->id }}', document.getElementById('deleteForm{{ $request->id }}'))"
                                            title="Hapus permintaan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <!-- Tags -->
                                @if($request->tags && count($request->tags) > 0)
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($request->tags as $tag)
                                                <span
                                                    class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($requests->hasPages())
                    <div class="mt-6">
                        {{ $requests->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 ">Belum ada permintaan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($status)
                                Tidak ada permintaan dengan status
                                {{ $status === 'active' ? 'aktif' : ($status === 'fulfilled' ? 'terpenuhi' : 'dibatalkan') }}.
                            @else
                                Mulai buat permintaan donasi untuk menarik perhatian donatur.
                            @endif
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('organisasi.create-request') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-teal-gelap">
                                Buat Permintaan Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Confirmation Modals -->
            @foreach($requests as $request)
                @if($request->status === 'active')
                    <!-- Fulfill Modal -->
                    <x-confirmation-modal id="fulfillModal{{ $request->id }}" title="Tandai Terpenuhi"
                        message="Apakah permintaan '{{ $request->title }}' sudah terpenuhi? Permintaan yang sudah terpenuhi tidak akan ditampilkan kepada donatur."
                        confirmText="Ya, Sudah Terpenuhi" cancelText="Batal" confirmClass="bg-blue-600 hover:bg-blue-700" />

                    <!-- Cancel Modal -->
                    <x-confirmation-modal id="cancelModal{{ $request->id }}" title="Batalkan Permintaan"
                        message="Apakah Anda yakin ingin membatalkan permintaan '{{ $request->title }}'? Permintaan yang dibatalkan tidak akan ditampilkan kepada donatur."
                        confirmText="Ya, Batalkan" cancelText="Tidak" confirmClass="bg-red-600 hover:bg-red-700" />
                @elseif($request->status === 'cancelled')
                    <!-- Reactivate Modal -->
                    <x-confirmation-modal id="reactiveModal{{ $request->id }}" title="Aktifkan Kembali"
                        message="Apakah Anda yakin ingin mengaktifkan kembali permintaan '{{ $request->title }}'? Permintaan akan kembali ditampilkan kepada donatur."
                        confirmText="Ya, Aktifkan" cancelText="Batal" confirmClass="bg-green-600 hover:bg-green-700" />
                @endif

                <!-- Delete Modal -->
                <x-confirmation-modal id="deleteModal{{ $request->id }}" title="Hapus Permintaan"
                    message="Apakah Anda yakin ingin menghapus permintaan '{{ $request->title }}'? Tindakan ini tidak dapat dibatalkan."
                    confirmText="Ya, Hapus" cancelText="Batal" confirmClass="bg-red-600 hover:bg-red-700" />
            @endforeach
        </div>
    </div>
</x-dashboard-layout>
