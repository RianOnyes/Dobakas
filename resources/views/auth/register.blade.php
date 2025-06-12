<x-guest-layout>
    <x-auth-card>
        {{-- Welcome Header --}}
        <div class="text-center mb-4">
            <h2 class="text-lg font-bold text-gray-900">
                Bergabung dengan Berkah BaBe
            </h2>
            <p class="text-gray-600 mt-1 text-sm">
                Mulai berbagi kebaikan hari ini
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <x-text-input
                type="text"
                name="name"
                id="name"
                label="Nama Lengkap"
                placeholder="Masukkan nama lengkap Anda"
                required />

            <!-- Email -->
            <x-text-input
                type="email"
                name="email"
                id="email"
                label="Email"
                placeholder="nama@email.com"
                required />

            <!-- Role Selection -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Daftar sebagai <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <!-- Donatur -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="donatur" class="sr-only peer" required>
                        <div class="p-3 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-berkah-secondary peer-checked:bg-berkah-cream/30 hover:border-gray-400">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-berkah-accent/20 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-berkah-secondary" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">Donatur</p>
                                    <p class="text-xs text-gray-600">Saya ingin donasi barang</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Organisasi -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="organisasi" class="sr-only peer" required>
                        <div class="p-3 border-2 border-gray-300 rounded-lg transition-all peer-checked:border-berkah-secondary peer-checked:bg-berkah-cream/30 hover:border-gray-400">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-berkah-accent/20 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-berkah-secondary" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">Organisasi</p>
                                    <p class="text-xs text-gray-600">Saya dari panti/yayasan</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <x-text-input
                type="password"
                name="password"
                id="password"
                label="Password"
                placeholder="Minimal 8 karakter"
                required />

            <!-- Confirm Password -->
            <x-text-input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                label="Konfirmasi Password"
                placeholder="Ulangi password Anda"
                required />

            <!-- Terms Agreement -->
            <div class="flex items-start space-x-2">
                <input id="terms" type="checkbox" class="mt-1 rounded border-gray-300 text-berkah-secondary shadow-sm focus:ring-berkah-secondary h-4 w-4" name="terms" required>
                <label for="terms" class="text-sm text-gray-600">
                    Saya setuju dengan <a href="#" class="text-berkah-secondary hover:text-berkah-primary transition-colors">syarat dan ketentuan</a> serta <a href="#" class="text-berkah-secondary hover:text-berkah-primary transition-colors">kebijakan privasi</a> Berkah BaBe
                </label>
            </div>
            @error('terms')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-berkah-secondary hover:bg-berkah-primary text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-berkah-secondary focus:ring-offset-2 text-sm">
                Buat Akun Sekarang
            </button>

            <!-- Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    Sudah punya akun? 
                    <a class="text-berkah-secondary hover:text-berkah-primary font-medium transition-colors" href="{{ route('login') }}">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
