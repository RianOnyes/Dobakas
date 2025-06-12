{{--
|--------------------------------------------------------------------------
| File: resources/views/components/navbar.blade.php
|--------------------------------------------------------------------------
|
| This is the reusable navbar component.
| It accepts two boolean props:
| - :show-login (defaults to true)
| - :show-register (defaults to true)
|
| You can control the visibility of the "Masuk" and "Daftar" buttons
| by passing `false` to these props.
|
--}}

@props([
    'showLogin'    => true,
    'showRegister' => true,
])

<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex-shrink-0">
                <a href="/" title="Home">
                    <div class="flex items-center">
                        <img src="{{ asset('images/berkah-babe-logo.png') }}" alt="Berkah BaBe" class="h-10 w-auto">
                        <span class="ml-3 text-xl font-bold text-berkah-teal-gelap">Berkah BaBe</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links / Buttons -->
            <div class="flex items-center">
                {{--
                | The @if directive checks the boolean value of the props.
                | If the prop is true, the button will be rendered.
                --}}
                @if ($showLogin)
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Masuk
                    </a>
                @endif

                @if ($showRegister)
                    <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-berkah-hijau-gelap hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Daftar
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
