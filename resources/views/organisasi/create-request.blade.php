<x-dashboard-layout>
    <x-slot name="header">Buat Permintaan Donasi</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-4xl mx-auto">
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buat Permintaan</h3>
                    <p class="text-gray-600">Buat permintaan donasi baru untuk menarik perhatian
                        donatur.</p>
                </div>
            </div>

            <!-- Request Form -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('organisasi.store-request') }}" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                Judul Permintaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                placeholder="Contoh: Bantuan Pakaian untuk Anak Yatim">
                            @error('title')
                                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category and Urgency Level -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="category" name="category" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pakaian" {{ old('category') === 'Pakaian' ? 'selected' : '' }}>Pakaian
                                    </option>
                                    <option value="Makanan" {{ old('category') === 'Makanan' ? 'selected' : '' }}>Makanan
                                    </option>
                                    <option value="Peralatan" {{ old('category') === 'Peralatan' ? 'selected' : '' }}>
                                        Peralatan</option>
                                    <option value="Elektronik" {{ old('category') === 'Elektronik' ? 'selected' : '' }}>
                                        Elektronik</option>
                                    <option value="Buku" {{ old('category') === 'Buku' ? 'selected' : '' }}>Buku</option>
                                    <option value="Mainan" {{ old('category') === 'Mainan' ? 'selected' : '' }}>Mainan
                                    </option>
                                    <option value="Alat Tulis" {{ old('category') === 'Alat Tulis' ? 'selected' : '' }}>
                                        Alat Tulis</option>
                                    <option value="Kesehatan" {{ old('category') === 'Kesehatan' ? 'selected' : '' }}>
                                        Kesehatan</option>
                                    <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Urgency Level -->
                            <div>
                                <label for="urgency_level"
                                    class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                    Tingkat Urgensi <span class="text-red-500">*</span>
                                </label>
                                <select id="urgency_level" name="urgency_level" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base">
                                    <option value="">Pilih Tingkat Urgensi</option>
                                    <option value="low" {{ old('urgency_level') === 'low' ? 'selected' : '' }}>Rendah
                                    </option>
                                    <option value="medium" {{ old('urgency_level') === 'medium' ? 'selected' : '' }}>
                                        Sedang</option>
                                    <option value="high" {{ old('urgency_level') === 'high' ? 'selected' : '' }}>Tinggi
                                    </option>
                                </select>
                                @error('urgency_level')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" rows="4" required
                                placeholder="Jelaskan secara detail barang apa yang Anda butuhkan, untuk apa barang tersebut akan digunakan, dan mengapa organisasi Anda membutuhkannya..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity and Location -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Quantity -->
                            <div>
                                <label for="quantity_needed"
                                    class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Dibutuhkan
                                </label>
                                <input type="number" id="quantity_needed" name="quantity_needed"
                                    value="{{ old('quantity_needed') }}" min="1" placeholder="Contoh: 50"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base">
                                @error('quantity_needed')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                    Lokasi
                                </label>
                                <input type="text" id="location" name="location" value="{{ old('location') }}"
                                    placeholder="Contoh: Jakarta Pusat"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base">
                                @error('location')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Needed By Date -->
                        <div>
                            <label for="needed_by" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                Dibutuhkan Sebelum
                            </label>
                            <input type="date" id="needed_by" name="needed_by" value="{{ old('needed_by') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base">
                            @error('needed_by')
                                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Opsional: Tentukan tanggal deadline
                                jika ada.</p>
                        </div>



                        <!-- Form Actions -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3 sm:space-y-0">
                            <div class="text-xs sm:text-sm text-gray-500">
                                <span class="text-red-500">*</span> Field wajib diisi
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <a href="{{ route('organisasi.requests') }}"
                                    class="w-full sm:w-auto px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-center text-sm font-medium">
                                    Batal
                                </a>

                                <button type="submit"
                                    class="w-full sm:w-auto px-4 py-2 bg-berkah-teal text-white rounded-md hover:bg-berkah-teal-gelap transition-colors">
                                    Buat Permintaan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="bg-gradient-to-r from-green-50 to-blue-50 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-4 sm:p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <h3 class="text-sm sm:text-lg font-medium text-gray-900 ">Tips Membuat
                                Permintaan yang Efektif</h3>
                            <div class="mt-2 text-xs sm:text-sm text-gray-600">
                                <ul class="space-y-1 list-disc list-inside">
                                    <li>Gunakan judul yang jelas dan spesifik</li>
                                    <li>Sertakan informasi tentang dampak positif yang akan dihasilkan</li>
                                    <li>Jelaskan secara detail mengapa bantuan ini dibutuhkan</li>
                                    <li>Tentukan deadline jika permintaan bersifat mendesak</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-dashboard-layout>