<x-guest-layout>
    <x-auth-card>
        {{-- Welcome Header --}}
        <div class="text-center mb-4">
            <h2 class="text-lg font-bold text-gray-900">
                Lupa Password?
            </h2>
            <p class="text-gray-600 mt-1 text-sm">
                Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link reset password.
            </p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-xs text-green-700">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <x-text-input
                type="email"
                name="email"
                id="email"
                label="Email"
                placeholder="nama@email.com"
                :value="old('email')"
                required
                autofocus />

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-berkah-secondary hover:bg-berkah-primary text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-berkah-secondary focus:ring-offset-2 text-sm">
                Kirim Link Reset Password
            </button>

            <!-- Back to Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    Ingat password Anda? 
                    <a class="text-berkah-secondary hover:text-berkah-primary font-medium transition-colors" href="{{ route('login') }}">
                        Kembali ke login
                    </a>
                </p>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
