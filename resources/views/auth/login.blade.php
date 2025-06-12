<x-guest-layout>
    <x-auth-card>
        {{-- Welcome Header --}}
        <div class="text-center mb-4">
            <h2 class="text-lg font-bold text-gray-900">
                Selamat Datang Kembali
            </h2>
            <p class="text-gray-600 mt-1 text-sm">
                Masuk ke akun Berkah BaBe Anda
            </p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-xs text-green-700">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <x-text-input
                type="email"
                name="email"
                id="email"
                label="Email"
                placeholder="nama@email.com"
                required
                autofocus />

            <!-- Password -->
            <x-text-input
                type="password"
                name="password"
                id="password"
                label="Password"
                placeholder="Masukkan password Anda"
                required />

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" class="rounded border-gray-300 text-berkah-secondary shadow-sm focus:ring-berkah-secondary h-4 w-4" name="remember">
                    <label for="remember" class="ml-2 text-sm text-gray-600">
                        Ingat saya
                    </label>
                </div>

                <a class="text-sm text-berkah-secondary hover:text-berkah-primary transition-colors" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-berkah-secondary hover:bg-berkah-primary text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-berkah-secondary focus:ring-offset-2 text-sm">
                Masuk ke Akun
            </button>

            <!-- Register Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    Belum punya akun? 
                    <a class="text-berkah-secondary hover:text-berkah-primary font-medium transition-colors" href="{{ route('register') }}">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
