<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berkah BaBe | Donasi Barang Bekas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-berkah-krem text-gray-900">

    {{-- Memanggil komponen navbar --}}
    <x-navbar />

    <main>
        {{-- 
        |--------------------------------------------------------------------------
        | Hero Section (FIXED)
        |--------------------------------------------------------------------------
        |
        | Perubahan:
        | 1. Padding diatur ulang pada <section> -> `pt-24 sm:pt-32` untuk memberi ruang dari header,
        |    dan `pb-32 sm:pb-40` untuk memberi ruang lebih di bawah sebelum kartu berikutnya.
        | 2. Padding tambahan pada <div> di dalamnya telah dihapus agar tidak duplikat.
        |
        --}}
        <section class="relative overflow-hidden pt-24 sm:pt-32 pb-32 sm:pb-40 px-4 sm:px-6 lg:px-8 text-white
                       bg-gradient-to-br from-berkah-teal-gelap to-berkah-hijau-gelap
                       before:content-[''] before:absolute before:inset-0 before:bg-[radial-gradient(circle_at_100%_0,rgba(255,255,255,0.1)_0%,transparent_70%)]">
            <div class="max-w-4xl mx-auto text-center relative z-10">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">
                    Donasi Mudah, Berkah Nyata.
                </h1>
                <p class="text-lg sm:text-xl font-light mb-10 max-w-2xl mx-auto">
                    Berkah BaBe: Jembatan kebaikan yang menghubungkan Anda dengan panti asuhan dan yayasan yang membutuhkan barang bekas layak pakai di Surabaya.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-full shadow-lg text-berkah-teal-gelap bg-white hover:bg-gray-100 transition duration-300 transform hover:scale-105">
                        Mulai Donasi Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-base font-bold rounded-full text-white hover:bg-white hover:text-berkah-teal-gelap transition duration-300 transform hover:scale-105">
                        Daftarkan Organisasi Anda
                    </a>
                </div>
            </div>
        </section>

        {{-- How It Works Section --}}
        <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-white shadow-lg rounded-lg mx-4 sm:mx-auto max-w-4xl -mt-16 relative z-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-center text-berkah-hijau-gelap mb-4">Bagaimana Kami Bekerja?</h2>
            <div class="h-1 w-20 bg-berkah-teal-gelap mx-auto mt-4 mb-8 rounded-full"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
                <div class="flex flex-col items-center p-4">
                    <div class="bg-berkah-mint p-4 rounded-full mb-4 shadow-md">
                        <svg class="h-10 w-10 text-berkah-teal-gelap" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">1. Unggah Donasi Anda</h3>
                    <p class="text-gray-600 text-center text-base">Mudah dan cepat, unggah detail serta foto barang bekas layak pakai Anda.</p>
                </div>
                <div class="flex flex-col items-center p-4">
                    <div class="bg-berkah-mint p-4 rounded-full mb-4 shadow-md">
                        <svg class="h-10 w-10 text-berkah-teal-gelap" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">2. Verifikasi Admin</h3>
                    <p class="text-gray-600 text-center text-base">Barang Anda diverifikasi dan dikelola oleh Admin kami sebelum disalurkan.</p>
                </div>
                <div class="flex flex-col items-center p-4">
                    <div class="bg-berkah-mint p-4 rounded-full mb-4 shadow-md">
                        <svg class="h-10 w-10 text-berkah-teal-gelap" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">3. Disalurkan ke Penerima</h3>
                    <p class="text-gray-600 text-center text-base">Barang disalurkan ke panti asuhan/yayasan yang tepat sesuai kebutuhan.</p>
                </div>
            </div>
        </section>

        {{-- Call to Action Section --}}
        <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 text-center bg-berkah-krem">
            <h2 class="text-3xl sm:text-4xl font-bold text-berkah-hijau-gelap mb-6">Siap Berbagi Berkah Hari Ini?</h2>
            <p class="text-lg text-gray-700 mb-10 max-w-xl mx-auto">
                Gabung bersama komunitas Berkah BaBe dan wujudkan Surabaya yang lebih peduli dan berkelanjutan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-full shadow-lg text-white bg-berkah-teal-gelap hover:bg-berkah-hijau-gelap transition duration-300 transform hover:scale-105">
                    Daftar Sebagai Donatur
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-berkah-teal-gelap text-base font-bold rounded-full text-berkah-teal-gelap bg-white hover:bg-berkah-mint transition duration-300 transform hover:scale-105">
                    Daftar Sebagai Organisasi
                </a>
            </div>
        </section>
    </main>

    <footer class="bg-berkah-hijau-gelap text-white text-center p-6">
        <p>&copy; {{ date('Y') }} Berkah BaBe. Semua Hak Cipta Dilindungi.</p>
        <p class="text-sm mt-2">Dibuat dengan ❤️ untuk Surabaya.</p>
    </footer>

</body>
</html>
