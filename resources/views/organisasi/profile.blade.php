<x-dashboard-layout>
    <x-slot name="header">Profil Organisasi</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Profil Organisasi</h3>
                    <p class="text-gray-600">Kelola informasi dan profil organisasi Anda.</p>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('organisasi.profile.update') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Organization Name -->
                        <div>
                            <label for="organization_name"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Organisasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="organization_name" name="organization_name"
                                value="{{ old('organization_name', $organizationDetail->organization_name ?? '') }}"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                placeholder="Masukkan nama lengkap organisasi">
                            @error('organization_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Person -->
                        <div>
                            <label for="contact_person"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Penanggung Jawab <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="contact_person" name="contact_person"
                                value="{{ old('contact_person', $organizationDetail->contact_person ?? '') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                placeholder="Nama lengkap penanggung jawab">
                            @error('contact_person')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Phone -->
                        <div>
                            <label for="contact_phone"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="contact_phone" name="contact_phone"
                                value="{{ old('contact_phone', $organizationDetail->contact_phone ?? '') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                placeholder="Contoh: 0812-3456-7890">
                            @error('contact_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Organization Address -->
                        <div>
                            <label for="organization_address"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Organisasi <span class="text-red-500">*</span>
                            </label>
                            <textarea id="organization_address" name="organization_address" rows="3" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                placeholder="Alamat lengkap organisasi">{{ old('organization_address', $organizationDetail->organization_address ?? '') }}</textarea>
                            @error('organization_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Organisasi
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                placeholder="Ceritakan tentang organisasi Anda, tujuan, dan kegiatan yang dilakukan...">{{ old('description', $organizationDetail->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Needs List -->
                        <div>
                            <label for="needs_list"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Daftar Kebutuhan
                            </label>
                            <div id="needs-container" class="space-y-2">
                                @if($organizationDetail && $organizationDetail->needs_list)
                                    @foreach($organizationDetail->needs_list as $index => $need)
                                        <div class="flex gap-2 need-item">
                                            <input type="text" name="needs_list[]"
                                                value="{{ old('needs_list.' . $index, $need) }}"
                                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                                placeholder="Contoh: Pakaian Anak, Buku Sekolah, dll">
                                            <button type="button" onclick="removeNeed(this)"
                                                class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors">
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex gap-2 need-item">
                                        <input type="text" name="needs_list[]" value="{{ old('needs_list.0') }}"
                                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                            placeholder="Contoh: Pakaian Anak, Buku Sekolah, dll">
                                        <button type="button" onclick="removeNeed(this)"
                                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors">
                                            Hapus
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-need"
                                class="mt-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition-colors">
                                Tambah Kebutuhan
                            </button>
                            <p class="mt-1 text-sm text-gray-500">Tambahkan jenis donasi yang
                                dibutuhkan organisasi Anda</p>
                            @error('needs_list')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Document Upload -->
                        <div>
                            <label for="document_url"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen Organisasi
                            </label>
                            @if($organizationDetail && $organizationDetail->document_url)
                                <div class="mb-2 p-3 bg-green-50 rounded-md">
                                    <p class="text-sm text-green-700">
                                        Dokumen saat ini:
                                        <a href="{{ asset('storage/' . $organizationDetail->document_url) }}"
                                            target="_blank" class="font-medium underline">
                                            Lihat Dokumen
                                        </a>
                                    </p>
                                </div>
                            @endif
                            <input type="file" id="document_url" name="document_url" accept=".pdf,.doc,.docx"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal">
                            <p class="mt-1 text-sm text-gray-500">Upload dokumen legitimasi
                                organisasi (PDF, DOC, DOCX, maksimal 2MB)</p>
                            @error('document_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit"
                                class="px-4 py-2 bg-berkah-teal text-white rounded-md hover:bg-berkah-teal-gelap transition-colors">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add new need input
        document.getElementById('add-need').addEventListener('click', function () {
            const container = document.getElementById('needs-container');
            const needItem = document.createElement('div');
            needItem.className = 'flex gap-2 need-item';
            needItem.innerHTML = `
                <input 
                    type="text" 
                    name="needs_list[]" 
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                    placeholder="Contoh: Pakaian Anak, Buku Sekolah, dll"
                >
                <button type="button" onclick="removeNeed(this)" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors">
                    Hapus
                </button>
            `;
            container.appendChild(needItem);
        });

        // Remove need input
        function removeNeed(button) {
            const container = document.getElementById('needs-container');
            const needItems = container.querySelectorAll('.need-item');

            // Don't remove if it's the last item
            if (needItems.length > 1) {
                button.parentElement.remove();
            }
        }
    </script>
</x-dashboard-layout>