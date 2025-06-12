<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gradient-to-b from-berkah-teal-gelap to-berkah-hijau-gelap px-6 pb-4">
        <!-- Logo -->
        <div class="flex h-16 shrink-0 items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/berkah-babe-logo.png') }}" alt="Berkah BaBe" class="w-10 h-10 rounded-full bg-white p-1">
                <div class="text-white ml-3">
                    <div class="text-xl font-bold">Berkah BaBe</div>
                    <div class="text-xs text-berkah-mint opacity-75">{{ ucfirst(auth()->user()->role) }} Dashboard</div>
                </div>
            </div>
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
                            <x-dashboard.nav-item route="organisasi.warehouse-donations" icon="search" label="Gudang Admin" />
                            <x-dashboard.nav-item route="organisasi.claimed-donations" icon="donations" label="Donasi Diklaim" />
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