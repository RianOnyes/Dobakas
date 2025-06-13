<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gradient-berkah-light">
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
<body class="h-full bg-gradient-berkah-light">
    <div class="min-h-full relative">
        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Main content -->
        <div class="lg:pl-72 relative z-10">
            <!-- Top header -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-2 sm:gap-x-4 border-b border-berkah-accent/20 bg-white/90 backdrop-blur-sm px-3 sm:px-4 shadow-sm lg:px-8">
                <!-- Mobile menu button -->
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" id="mobile-menu-button">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-200 lg:hidden"></div>

                <div class="flex flex-1 gap-x-2 sm:gap-x-4 self-stretch lg:gap-x-6">
                    <!-- Page title -->
                    <div class="flex items-center min-w-0 flex-1">
                        @isset($header)
                            <h1 class="text-base sm:text-lg lg:text-xl font-semibold leading-6 text-gray-900 truncate">{{ $header }}</h1>
                        @endisset
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center gap-x-2 sm:gap-x-4 lg:gap-x-6">
                        <!-- Notifications -->
                        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                        <!-- Separator -->
                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200"></div>

                        <!-- Profile dropdown -->
                        <div class="relative group">
                            <button type="button" class="-m-1.5 flex items-center p-1.5">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-7 w-7 sm:h-8 sm:w-8 rounded-full bg-gradient-berkah-dark flex items-center justify-center">
                                    <span class="text-xs sm:text-sm font-medium text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
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
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Profil Kamu</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="py-4 sm:py-6">
                <div class="px-3 sm:px-4 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div id="mobile-sidebar" class="relative z-50 lg:hidden hidden opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="fixed inset-0 bg-gray-900/80" id="mobile-overlay"></div>
        
        <div class="fixed inset-0 flex">
            <div class="relative mr-16 flex w-full max-w-xs flex-1">
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gradient-berkah-dark px-4 pb-4 transform -translate-x-full transition-transform duration-300" id="mobile-sidebar-panel">
                    <!-- Close button -->
                    <div class="flex h-16 shrink-0 items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-berkah-primary font-bold text-sm mr-2">
                                BB
                            </div>
                            <div class="text-white">
                                <div class="text-lg font-bold">Berkah BaBe</div>
                                <div class="text-xs text-berkah-accent opacity-75">{{ ucfirst(auth()->user()->role) }} Dashboard</div>
                            </div>
                        </div>
                        <button type="button" id="close-mobile-sidebar" class="-m-2.5 p-2.5 text-white hover:text-berkah-mint">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    @if(auth()->user()->isAdmin())
                                        <!-- Admin Navigation -->
                                        <x-dashboard.nav-item route="admin.dashboard" icon="home" label="Dashboard" />
                                        <x-dashboard.nav-item route="admin.users" icon="users" label="Kelola Pengguna" />
                                        <x-dashboard.nav-item route="admin.statistics" icon="chart" label="Statistik & Laporan" />
                                        <x-dashboard.nav-item route="admin.donations" icon="donations" label="Kelola Donasi" />
                                        <x-dashboard.nav-item route="admin.organizations" icon="organizations" label="Kelola Organisasi" />
                                        <x-dashboard.nav-item route="admin.settings" icon="settings" label="Pengaturan" />
                                    @elseif(auth()->user()->isDonatur())
                                        <!-- Donatur Navigation -->
                                        <x-dashboard.nav-item route="donatur.dashboard" icon="home" label="Dashboard" />
                                        <x-dashboard.nav-item route="donatur.buat-donasi" icon="plus" label="Buat Donasi" />
                                        <x-dashboard.nav-item route="donatur.cari-bantuan" icon="search" label="Cari Bantuan" />
                                        <x-dashboard.nav-item route="donatur.donasi-saya" icon="donations" label="Donasi Saya" />
                                        <x-dashboard.nav-item route="donatur.riwayat" icon="history" label="Riwayat" />
                                    @elseif(auth()->user()->isOrganisasi())
                                        <!-- Organisasi Navigation -->
                                        <x-dashboard.nav-item route="organisasi.dashboard" icon="home" label="Dashboard" />
                                        <x-dashboard.nav-item route="organisasi.warehouse-donations" icon="search" label="Jelajahi Gudang Admin" />
                                        <x-dashboard.nav-item route="organisasi.claimed-donations" icon="donations" label="Kelola Donasi Diklaim" />
                                        <x-dashboard.nav-item route="organisasi.requests" icon="requests" label="Permintaan Saya" />
                                        <x-dashboard.nav-item route="organisasi.create-request" icon="plus" label="Buat Permintaan" />
                                        <x-dashboard.nav-item route="organisasi.profile" icon="profile" label="Profil Organisasi" />
                                    @endif
                                </ul>
                            </li>

                            <!-- Bottom section -->
                            <li class="mt-auto">
                                <ul role="list" class="-mx-2 space-y-1">
                                    <x-dashboard.nav-item route="profile.edit" icon="profile" label="Profil Saya" />
                                    
                                    <!-- Logout -->
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="group flex w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-berkah-mint hover:text-white hover:bg-berkah-hijau-gelap transition-colors">
                                                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                                </svg>
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle functionality
        function openMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const sidebarPanel = document.getElementById('mobile-sidebar-panel');
            
            if (sidebar && sidebarPanel) {
                sidebar.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
                sidebar.classList.add('opacity-100', 'pointer-events-auto');
                
                setTimeout(() => {
                    sidebarPanel.classList.remove('-translate-x-full');
                }, 10);
                
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const sidebarPanel = document.getElementById('mobile-sidebar-panel');
            
            if (sidebar && sidebarPanel) {
                sidebarPanel.classList.add('-translate-x-full');
                sidebar.classList.remove('opacity-100', 'pointer-events-auto');
                sidebar.classList.add('opacity-0', 'pointer-events-none');
                
                setTimeout(() => {
                    sidebar.classList.add('hidden');
                }, 300);
                
                document.body.style.overflow = 'auto';
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu button
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', openMobileSidebar);
            }

            // Close button
            const closeSidebarButton = document.getElementById('close-mobile-sidebar');
            if (closeSidebarButton) {
                closeSidebarButton.addEventListener('click', closeMobileSidebar);
            }

            // Close when clicking on overlay
            const mobileOverlay = document.getElementById('mobile-overlay');
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', closeMobileSidebar);
            }

            // Close sidebar when clicking on navigation links (for better UX)
            const mobileSidebar = document.getElementById('mobile-sidebar');
            if (mobileSidebar) {
                const navLinks = mobileSidebar.querySelectorAll('a[href]:not([href="#"])');
                navLinks.forEach(link => {
                    link.addEventListener('click', closeMobileSidebar);
                });
            }

            // Handle escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const sidebar = document.getElementById('mobile-sidebar');
                    if (sidebar && !sidebar.classList.contains('hidden')) {
                        closeMobileSidebar();
                    }
                }
            });
        });
    </script>

    <!-- Additional scripts stack -->
    @stack('scripts')
</body>
</html> 