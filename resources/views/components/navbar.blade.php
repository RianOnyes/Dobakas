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
                        {{-- You can replace this SVG with your own logo --}}
                        <svg class="h-8 w-auto text-indigo-600" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM8.29 16.71c.39.39 1.02.39 1.41 0L12 14.41l2.29 2.3c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L13.41 13l2.3-2.29c.39-.39.39-1.02 0-1.41a.9959.9959 0 00-1.41 0L12 11.59l-2.29-2.3c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41L10.59 13l-2.3 2.29c-.39.39-.39 1.02 0 1.41z" />
                        </svg>
                        <span class="ml-3 text-xl font-bold text-gray-800">YourLogo</span>
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
