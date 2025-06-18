{{--
|--------------------------------------------------------------------------
| File: resources/views/components/auth-card.blade.php
|--------------------------------------------------------------------------
|
| Komponen ini berfungsi sebagai wadah/kartu untuk form autentikasi
| seperti login dan register.
|
--}}
<div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-berkah-cream via-white to-berkah-accent/10">
    {{-- Logo --}}
    <div class="text-center mb-6">
        <a href="/" class="inline-block">
            <div class="flex items-center justify-center">
                {{-- Logo Image --}}
                <div class="w-32 h-32 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/berkah-babe-logo.png') }}" alt="Berkah BaBe Logo" class="w-32 h-32 object-contain">
                </div>
            </div>
        </a>
    </div>

    {{-- Form Container --}}
    <div class="w-full max-w-sm bg-white rounded-xl shadow-xl border border-gray-100 p-6">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    <div class="mt-4 text-center">
        <p class="text-xs text-gray-500">
            &copy; {{ date('Y') }} Berkah BaBe. Semua hak cipta dilindungi.
        </p>
    </div>
</div>
