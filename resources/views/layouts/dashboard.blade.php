<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-berkah-krem">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($header) ? $header . ' - ' : '' }}{{ config('app.name', 'Berkah BaBe') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-berkah-krem">
    <div class="min-h-full">
        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Main content -->
        <div class="lg:pl-72">
            <!-- Top header -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <!-- Mobile menu button -->
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" id="mobile-menu-button">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-200 lg:hidden"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <!-- Page title -->
                    <div class="flex items-center">
                        @isset($header)
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">{{ $header }}</h1>
                        @endisset
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center gap-x-4 lg:gap-x-6 ml-auto">
                        <!-- Notifications -->
                        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                        <!-- Separator -->
                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200"></div>

                        <!-- Profile dropdown -->
                        <div class="relative group">
                            <button type="button" class="-m-1.5 flex items-center p-1.5">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full bg-berkah-teal-gelap flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900">{{ auth()->user()->name }}</span>
                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>

                            <!-- Dropdown menu -->
                            <div class="opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5">
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Your profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="py-6">
                <div class="px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay (hidden by default, can be toggled with custom JS if needed) -->
    <div id="mobile-sidebar" class="relative z-50 lg:hidden hidden">
        <div class="fixed inset-0 bg-gray-900/80 transition-opacity duration-300"></div>
        
        <div class="fixed inset-0 flex">
            <div class="relative mr-16 flex w-full max-w-xs flex-1 transform -translate-x-full transition-transform duration-300">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" id="close-mobile-sidebar" class="-m-2.5 p-2.5">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <x-dashboard.sidebar />
            </div>
        </div>
    </div>

    <script>
        // Simple mobile menu toggle with vanilla JS
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const sidebar = document.getElementById('mobile-sidebar');
            const sidebarPanel = sidebar.querySelector('.transform');
            
            sidebar.classList.remove('hidden');
            setTimeout(() => {
                sidebarPanel.classList.remove('-translate-x-full');
            }, 10);
        });

        document.getElementById('close-mobile-sidebar')?.addEventListener('click', function() {
            const sidebar = document.getElementById('mobile-sidebar');
            const sidebarPanel = sidebar.querySelector('.transform');
            
            sidebarPanel.classList.add('-translate-x-full');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        });
    </script>
</body>
</html> 