{{--
|--------------------------------------------------------------------------
| File: resources/views/components/auth-card.blade.php
|--------------------------------------------------------------------------
|
| Komponen ini berfungsi sebagai wadah/kartu untuk form autentikasi
| seperti login dan register.
|
--}}
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-berkah-krem">
    {{-- Logo --}}
    <div>
        <a href="/">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-berkah-teal-gelap rounded-full flex items-center justify-center text-white font-bold text-xl mr-3">
                    BB
                </div>
                <span class="text-3xl font-bold text-berkah-hijau-gelap">Berkah BaBe</span>
            </div>
        </a>
    </div>

    {{-- Form Container --}}
    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
