<x-dashboard-layout>
    <x-slot name="header">Detail Permintaan</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('organisasi.requests') }}"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Permintaan
                </a>
            </div>

            <!-- Request Detail Card -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $request->getStatusBadgeClass() }}">
                            {{ $request->getStatusLabel() }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $request->getUrgencyBadgeClass() }}">
                            {{ $request->getUrgencyLabel() }}
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $request->title }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <p class="text-sm text-gray-900">{{ $request->category }}</p>
                        </div>

                        @if($request->quantity_needed)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Dibutuhkan</label>
                                <p class="text-sm text-gray-900">{{ $request->quantity_needed }}</p>
                            </div>
                        @endif

                        @if($request->needed_by)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dibutuhkan Sebelum</label>
                                <p class="text-sm text-gray-900">{{ $request->needed_by->format('d M Y') }}</p>
                            </div>
                        @endif

                        @if($request->location)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                <p class="text-sm text-gray-900">{{ $request->location }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <p class="text-sm text-gray-900 leading-relaxed">{{ $request->description }}</p>
                    </div>

                    <div class="flex gap-2">
                        @if($request->status === 'active')
                            <form method="POST" action="{{ route('organisasi.request.status', $request) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="fulfilled">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Tandai Terpenuhi
                                </button>
                            </form>

                            <form method="POST" action="{{ route('organisasi.request.status', $request) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Batalkan
                                </button>
                            </form>
                        @elseif($request->status === 'cancelled')
                            <form method="POST" action="{{ route('organisasi.request.status', $request) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="active">
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Aktifkan Kembali
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('organisasi.request.delete', $request) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus permintaan ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-xs text-gray-500">
                            Dibuat {{ $request->created_at->diffForHumans() }} •
                            Terakhir diperbarui {{ $request->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>