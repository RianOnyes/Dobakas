<x-dashboard-layout>
    <x-slot name="header">Buat Donasi</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buat Donasi</h3>
                    <p class="text-gray-600">Bagikan barang bekas yang masih layak pakai untuk
                        membantu mereka yang membutuhkan.</p>
                </div>
            </div>

            <!-- Donation Form -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('donatur.store-donasi-barang') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Donation Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-black mb-2">
                                Judul Donasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                placeholder="Contoh: Baju Anak Bekas Layak Pakai"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="">Pilih Kategori</option>
                                <option value="Pakaian" {{ old('category') === 'Pakaian' ? 'selected' : '' }}>Pakaian
                                </option>
                                <option value="Buku" {{ old('category') === 'Buku' ? 'selected' : '' }}>Buku</option>
                                <option value="Elektronik" {{ old('category') === 'Elektronik' ? 'selected' : '' }}>
                                    Elektronik</option>
                                <option value="Perabot" {{ old('category') === 'Perabot' ? 'selected' : '' }}>Perabot
                                </option>
                                <option value="Mainan" {{ old('category') === 'Mainan' ? 'selected' : '' }}>Mainan
                                </option>
                                <option value="Alat Tulis" {{ old('category') === 'Alat Tulis' ? 'selected' : '' }}>Alat
                                    Tulis</option>
                                <option value="Peralatan Rumah Tangga" {{ old('category') === 'Peralatan Rumah Tangga' ? 'selected' : '' }}>Peralatan Rumah Tangga</option>
                                <option value="Olahraga" {{ old('category') === 'Olahraga' ? 'selected' : '' }}>Olahraga
                                </option>
                                <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Barang
                            </label>
                            <textarea id="description" name="description" rows="4"
                                placeholder="Jelaskan kondisi barang, jumlah, dan informasi penting lainnya..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Photos -->
                        <div>
                            <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Barang (Opsional)
                            </label>
                            <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">
                                Maksimal 5 foto, format JPG/PNG, ukuran maksimal 2MB per foto
                            </p>
                            @error('photos.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pickup Preference -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Preferensi Pengambilan <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <input type="radio" id="self_deliver" name="pickup_preference" value="self_deliver"
                                        {{ old('pickup_preference', 'self_deliver') === 'self_deliver' ? 'checked' : '' }}
                                        class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    <div class="ml-3">
                                        <label for="self_deliver"
                                            class="text-sm font-medium text-gray-700">
                                            Antar Sendiri
                                        </label>
                                        <p class="text-sm text-gray-500">
                                            Saya akan mengantar barang ke pusat admin Berkah BaBe
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <input type="radio" id="needs_pickup" name="pickup_preference" value="needs_pickup"
                                        {{ old('pickup_preference') === 'needs_pickup' ? 'checked' : '' }}
                                        class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    <div class="ml-3">
                                        <label for="needs_pickup"
                                            class="text-sm font-medium text-gray-700">
                                            Perlu Dijemput
                                        </label>
                                        <p class="text-sm text-gray-500">
                                            Tim admin akan menjemput barang di lokasi saya
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @error('pickup_preference')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location (for pickup) -->
                        <div id="location-field" class="hidden">
                            <label for="location"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Penjemputan
                            </label>
                            <textarea id="location" name="location" rows="3"
                                placeholder="Masukkan alamat lengkap untuk penjemputan..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('location') }}</textarea>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('donatur.buat-donasi') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                                Kembali
                            </a>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                Buat Donasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide location field based on pickup preference
        document.addEventListener('DOMContentLoaded', function () {
            const selfDeliver = document.getElementById('self_deliver');
            const needsPickup = document.getElementById('needs_pickup');
            const locationField = document.getElementById('location-field');
            const locationInput = document.getElementById('location');

            function toggleLocationField() {
                if (needsPickup.checked) {
                    locationField.classList.remove('hidden');
                    locationInput.required = true;
                } else {
                    locationField.classList.add('hidden');
                    locationInput.required = false;
                }
            }

            selfDeliver.addEventListener('change', toggleLocationField);
            needsPickup.addEventListener('change', toggleLocationField);

            // Initial check
            toggleLocationField();
        });
    </script>
</x-dashboard-layout>
