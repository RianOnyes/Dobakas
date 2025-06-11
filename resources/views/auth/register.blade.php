<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Berkah BaBe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <x-auth-card>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <x-text-input
                type="text"
                name="name"
                id="name"
                label="Nama Lengkap"
                :value="old('name')"
                required
                autofocus />

            <!-- Username -->
            <x-text-input
                type="text"
                name="username"
                id="username"
                label="Username"
                :value="old('username')"
                required />

            <!-- Password -->
            <x-text-input
                type="password"
                name="password"
                id="password"
                label="Password"
                required />
                
            <!-- Confirm Password -->
            <x-text-input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                label="Konfirmasi Password"
                required />

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Sudah punya akun?
                </a>

                <button type="submit" class="ml-4 inline-flex items-center px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-berkah-teal-gelap hover:bg-berkah-hijau-gelap focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-berkah-teal-gelap transition">
                    Daftar
                </button>
            </div>
        </form>
    </x-auth-card>

</body>
</html>
