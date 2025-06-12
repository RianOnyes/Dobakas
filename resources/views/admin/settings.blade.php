<x-dashboard-layout>
    <x-slot name="header">Pengaturan</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- System Settings -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Pengaturan Sistem</h3>
                    
                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Site Settings -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Pengaturan Situs</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Situs</label>
                                    <input 
                                        type="text" 
                                        name="site_name" 
                                        id="site_name" 
                                        value="Berkah BaBe"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                </div>

                                <div>
                                    <label for="site_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Situs</label>
                                    <input 
                                        type="email" 
                                        name="site_email" 
                                        id="site_email" 
                                        value="admin@berkahhbabe.com"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Situs</label>
                                <textarea 
                                    name="site_description" 
                                    id="site_description" 
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                >Platform donasi barang bekas untuk membantu sesama dengan cara yang berkelanjutan.</textarea>
                            </div>
                        </div>

                        <!-- Donation Settings -->
                        <div class="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Pengaturan Donasi</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="max_photos" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Maksimal Foto per Donasi</label>
                                    <input 
                                        type="number" 
                                        name="max_photos" 
                                        id="max_photos" 
                                        value="5"
                                        min="1"
                                        max="10"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                </div>

                                <div>
                                    <label for="auto_approve" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Persetujuan Otomatis</label>
                                    <select 
                                        name="auto_approve" 
                                        id="auto_approve"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                        <option value="0">Manual Review</option>
                                        <option value="1">Auto Approve</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="require_verification" 
                                        value="1" 
                                        checked
                                        class="rounded border-gray-300 dark:border-gray-700 text-berkah-teal shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Wajib verifikasi email untuk donatur</span>
                                </label>
                            </div>
                        </div>

                        <!-- Notification Settings -->
                        <div class="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Pengaturan Notifikasi</h4>
                            
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="email_notifications" 
                                        value="1" 
                                        checked
                                        class="rounded border-gray-300 dark:border-gray-700 text-berkah-teal shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Kirim notifikasi email</span>
                                </label>

                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="admin_notifications" 
                                        value="1" 
                                        checked
                                        class="rounded border-gray-300 dark:border-gray-700 text-berkah-teal shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notifikasi admin untuk donasi baru</span>
                                </label>

                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="user_notifications" 
                                        value="1" 
                                        checked
                                        class="rounded border-gray-300 dark:border-gray-700 text-berkah-teal shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Notifikasi pengguna untuk update status</span>
                                </label>
                            </div>
                        </div>

                        <!-- Security Settings -->
                        <div class="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Pengaturan Keamanan</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="session_timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Session Timeout (menit)</label>
                                    <input 
                                        type="number" 
                                        name="session_timeout" 
                                        id="session_timeout" 
                                        value="120"
                                        min="30"
                                        max="480"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                </div>

                                <div>
                                    <label for="max_login_attempts" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Maksimal Percobaan Login</label>
                                    <input 
                                        type="number" 
                                        name="max_login_attempts" 
                                        id="max_login_attempts" 
                                        value="5"
                                        min="3"
                                        max="10"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="force_ssl" 
                                        value="1" 
                                        checked
                                        class="rounded border-gray-300 dark:border-gray-700 text-berkah-teal shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Paksa HTTPS</span>
                                </label>

                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="two_factor_auth" 
                                        value="1"
                                        class="rounded border-gray-300 dark:border-gray-700 text-berkah-teal shadow-sm focus:border-berkah-teal focus:ring-berkah-teal"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan Two-Factor Authentication</span>
                                </label>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-berkah-teal border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-berkah-teal-gelap transition ease-in-out duration-150"
                            >
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Informasi Sistem</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Server Info</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">PHP Version:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ PHP_VERSION }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Laravel Version:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ app()->version() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Server:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Database Info</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Database:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ config('database.default') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Environment:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ app()->environment() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Debug Mode:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Mode Maintenance</h3>
                    
                    <div class="bg-yellow-50 dark:bg-yellow-900/50 border border-yellow-200 dark:border-yellow-800 rounded-md p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Peringatan</h3>
                                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                    <p>Mode maintenance akan menonaktifkan akses situs untuk semua pengguna kecuali admin.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Aktifkan Mode Maintenance</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nonaktifkan sementara akses situs untuk pemeliharaan</p>
                        </div>
                        <button 
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            Aktifkan Maintenance
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-dashboard-layout> 