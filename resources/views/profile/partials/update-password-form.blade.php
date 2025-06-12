<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-text-input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    label="Password Saat Ini"
                    placeholder="Masukkan password saat ini"
                    autocomplete="current-password" />
            </div>

            <div>
                <x-text-input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    label="Password Baru"
                    placeholder="Masukkan password baru (minimal 8 karakter)"
                    autocomplete="new-password" />
            </div>

            <div>
                <x-text-input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    label="Konfirmasi Password Baru"
                    placeholder="Ulangi password baru"
                    autocomplete="new-password" />
            </div>
        </div>

        <div class="bg-berkah-cream/30 border border-berkah-accent/20 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 mb-2">Persyaratan Password:</h4>
            <ul class="text-sm text-gray-600 space-y-1">
                <li class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-berkah-secondary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                    </svg>
                    Minimal 8 karakter
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-berkah-secondary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                    </svg>
                    Kombinasi huruf besar dan kecil
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-berkah-secondary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                    </svg>
                    Gunakan angka dan simbol untuk keamanan ekstra
                </li>
            </ul>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-berkah-secondary hover:bg-berkah-primary text-white font-semibold rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-berkah-secondary focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2z"/>
                </svg>
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600 font-medium">
                    Password berhasil diperbarui!
                </p>
            @endif
        </div>
    </form>
</section>
