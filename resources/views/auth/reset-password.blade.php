<x-guest-layout>
    <x-auth-card>
        {{-- Welcome Header --}}
        <div class="text-center mb-4">
            <h2 class="text-lg font-bold text-gray-900">
                Reset Password
            </h2>
            <p class="text-gray-600 mt-1 text-sm">
                Masukkan email dan password baru Anda
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <x-text-input
                type="email"
                name="email"
                id="email"
                label="Email"
                placeholder="nama@email.com"
                :value="old('email', $request->email)"
                required
                autofocus />

            <!-- Password -->
            <x-text-input
                type="password"
                name="password"
                id="password"
                label="Password Baru"
                placeholder="Masukkan password baru"
                required />

            <!-- Confirm Password -->
            <x-text-input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                label="Konfirmasi Password"
                placeholder="Ulangi password baru"
                required />

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-berkah-secondary hover:bg-berkah-primary text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-berkah-secondary focus:ring-offset-2 text-sm">
                Reset Password
            </button>

            <!-- Back to Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    Kembali ke 
                    <a class="text-berkah-secondary hover:text-berkah-primary font-medium transition-colors" href="{{ route('login') }}">
                        halaman login
                    </a>
                </p>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
