<x-dashboard-layout>
    <x-slot name="header">Buat Permintaan Donasi</x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-4xl mx-auto">
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

            <!-- Page Header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Buat Permintaan Donasi</h3>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Buat permintaan donasi untuk barang-barang yang dibutuhkan organisasi Anda. Pastikan informasi yang Anda berikan lengkap dan jelas.</p>
                </div>
            </div>

            <!-- Request Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('organisasi.store-request') }}" class="space-y-4 sm:space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Judul Permintaan <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                required
                                placeholder="Contoh: Bantuan Alat Tulis untuk Anak-anak Desa"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                            >
                            @error('title')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category and Urgency Level -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="category" 
                                    name="category" 
                                    required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                                >
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pakaian" {{ old('category') === 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                                    <option value="Makanan" {{ old('category') === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="Peralatan" {{ old('category') === 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                    <option value="Elektronik" {{ old('category') === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                    <option value="Buku" {{ old('category') === 'Buku' ? 'selected' : '' }}>Buku</option>
                                    <option value="Mainan" {{ old('category') === 'Mainan' ? 'selected' : '' }}>Mainan</option>
                                    <option value="Alat Tulis" {{ old('category') === 'Alat Tulis' ? 'selected' : '' }}>Alat Tulis</option>
                                    <option value="Kesehatan" {{ old('category') === 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                    <option value="Lainnya" {{ old('category') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Urgency Level -->
                            <div>
                                <label for="urgency_level" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tingkat Urgensi <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="urgency_level" 
                                    name="urgency_level" 
                                    required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                                >
                                    <option value="">Pilih Tingkat Urgensi</option>
                                    <option value="low" {{ old('urgency_level') === 'low' ? 'selected' : '' }}>Rendah</option>
                                    <option value="medium" {{ old('urgency_level') === 'medium' ? 'selected' : '' }}>Sedang</option>
                                    <option value="high" {{ old('urgency_level') === 'high' ? 'selected' : '' }}>Tinggi</option>
                                </select>
                                @error('urgency_level')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4"
                                required
                                placeholder="Jelaskan secara detail barang apa yang Anda butuhkan, untuk apa barang tersebut akan digunakan, dan mengapa organisasi Anda membutuhkannya..."
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity and Location -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Quantity -->
                            <div>
                                <label for="quantity_needed" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jumlah Dibutuhkan
                                </label>
                                <input 
                                    type="number" 
                                    id="quantity_needed" 
                                    name="quantity_needed" 
                                    value="{{ old('quantity_needed') }}"
                                    min="1"
                                    placeholder="Contoh: 50"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                                >
                                @error('quantity_needed')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Lokasi
                                </label>
                                <input 
                                    type="text" 
                                    id="location" 
                                    name="location" 
                                    value="{{ old('location') }}"
                                    placeholder="Contoh: Jakarta Pusat"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                                >
                                @error('location')
                                    <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Needed By Date -->
                        <div>
                            <label for="needed_by" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Dibutuhkan Sebelum
                            </label>
                            <input 
                                type="date" 
                                id="needed_by" 
                                name="needed_by" 
                                value="{{ old('needed_by') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                            >
                            @error('needed_by')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Opsional: Tentukan tanggal deadline jika ada.</p>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label for="tags_input" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tag/Kata Kunci
                            </label>
                            <input 
                                type="text" 
                                id="tags_input" 
                                placeholder="Ketik tag dan tekan Enter atau koma untuk menambahkan. Contoh: anak-anak, pendidikan, mendesak"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal text-sm sm:text-base"
                            >
                            <input type="hidden" name="tags" id="tags_hidden" value="{{ old('tags') }}">
                            
                            <!-- Tags Display -->
                            <div id="tags_display" class="mt-2 flex flex-wrap gap-1 sm:gap-2"></div>
                            
                            @error('tags')
                                <p class="mt-1 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Tag membantu donatur menemukan permintaan Anda. Gunakan kata kunci yang relevan.
                            </p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3 sm:space-y-0">
                            <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                <span class="text-red-500">*</span> Field wajib diisi
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <a 
                                    href="{{ route('organisasi.requests') }}" 
                                    class="w-full sm:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-center text-sm font-medium"
                                >
                                    Batal
                                </a>
                                
                                <button 
                                    type="submit" 
                                    class="w-full sm:w-auto px-6 py-2 bg-berkah-teal text-white rounded-md hover:bg-berkah-hijau-gelap transition-colors font-medium text-sm"
                                >
                                    Buat Permintaan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="mt-4 sm:mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 sm:p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm sm:text-base font-medium text-blue-800 dark:text-blue-200">Tips Membuat Permintaan yang Efektif</h3>
                        <div class="mt-2 text-xs sm:text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Gunakan judul yang jelas dan spesifik</li>
                                <li>Jelaskan dengan detail mengapa barang tersebut dibutuhkan</li>
                                <li>Sertakan informasi tentang dampak positif yang akan dihasilkan</li>
                                <li>Gunakan tag yang relevan untuk memudahkan pencarian</li>
                                <li>Tentukan deadline jika permintaan bersifat mendesak</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Tags Management
        let tags = [];
        
        // Initialize tags from old input
        const oldTags = document.getElementById('tags_hidden').value;
        if (oldTags) {
            try {
                tags = JSON.parse(oldTags);
                displayTags();
            } catch (e) {
                tags = [];
            }
        }

        const tagsInput = document.getElementById('tags_input');
        const tagsDisplay = document.getElementById('tags_display');
        const tagsHidden = document.getElementById('tags_hidden');

        tagsInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                addTag();
            }
        });

        tagsInput.addEventListener('blur', function() {
            addTag();
        });

        function addTag() {
            const tagText = tagsInput.value.trim();
            if (tagText && !tags.includes(tagText) && tags.length < 10) {
                tags.push(tagText);
                tagsInput.value = '';
                displayTags();
                updateHiddenInput();
            }
        }

        function removeTag(index) {
            tags.splice(index, 1);
            displayTags();
            updateHiddenInput();
        }

        function displayTags() {
            tagsDisplay.innerHTML = '';
            tags.forEach((tag, index) => {
                const tagElement = document.createElement('span');
                tagElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-berkah-teal text-white';
                tagElement.innerHTML = `
                    ${tag}
                    <button type="button" onclick="removeTag(${index})" class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full hover:bg-berkah-hijau-gelap">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                `;
                tagsDisplay.appendChild(tagElement);
            });
        }

        function updateHiddenInput() {
            tagsHidden.value = JSON.stringify(tags);
        }
    </script>
    @endpush
</x-dashboard-layout> 