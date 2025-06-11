<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Berkah BaBe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <x-auth-card>
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <x-text-input
                type="email"
                name="email"
                id="email"
                label="Email"
                :value="old('email')"
                required
                autofocus />

            <!-- Password -->
            <x-text-input
                type="password"
                name="password"
                id="password"
                label="Password"
                required />

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-berkah-teal-gelap shadow-sm focus:ring-berkah-teal-gelap" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    Belum punya akun?
                </a>

                <button type="submit" class="ml-4 inline-flex items-center px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-berkah-teal-gelap hover:bg-berkah-hijau-gelap focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-berkah-teal-gelap transition">
                    Masuk
                </button>
            </div>
        </form>
    </x-auth-card>

</body>
</html>
