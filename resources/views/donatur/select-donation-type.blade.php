<x-dashboard-layout>
    <x-slot name="header">Pilih Jenis Donasi</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Alert Popup -->
            @if(session('success'))
                <div id="success-popup" class="fixed inset-0 z-50 overflow-y-auto opacity-0 transition-opacity duration-300"
                    style="display: none;">
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-900 bg-opacity-75"></div>
                        </div>

                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all duration-300 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 scale-95 opacity-0"
                            id="popup-content">
                            <div class="text-center">
                                <div
                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl leading-6 font-bold text-gray-900 mb-2">
                                    🎉 Donasi Berhasil Dibuat!
                                </h3>
                                <p class="text-sm text-gray-600 mb-6">
                                    {{ session('success') }}
                                </p>
                                <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-3">
                                    <button onclick="closePopup()" type="button"
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                        OK, Buat Lagi
                                    </button>
                                    <a href="{{ route('donatur.donasi-saya') }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                        Lihat Donasi Saya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Header Info -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Pilih Jenis Donasi Anda
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Silakan pilih jenis donasi yang ingin Anda berikan. Anda dapat menyumbangkan barang bekas yang
                        masih layak pakai
                        atau memberikan donasi uang untuk membantu operasional organisasi.
                    </p>
                </div>
            </div>

            <!-- Donation Type Options -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Donate Goods -->
                <div
                    class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-8 text-center">
                        <div class="mb-6">
                            <div
                                class="mx-auto w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            Donasi Barang
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm leading-relaxed">
                            Sumbangkan barang bekas yang masih layak pakai seperti pakaian, buku, elektronik, mainan,
                            dan lainnya
                            untuk membantu mereka yang membutuhkan.
                        </p>
                        <ul class="text-left text-sm text-gray-600 dark:text-gray-400 mb-8 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Mudah dan praktis
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Ramah lingkungan
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Bantuan langsung
                            </li>
                        </ul>
                        <a href="{{ route('donatur.buat-donasi-barang') }}"
                            class="inline-flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Donasi Barang
                        </a>
                    </div>
                </div>

                <!-- Donate Money -->
                <div
                    class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-8 text-center">
                        <div class="mb-6">
                            <div
                                class="mx-auto w-20 h-20 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            Donasi Uang
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm leading-relaxed">
                            Berikan bantuan berupa uang tunai untuk membantu operasional organisasi, pembelian kebutuhan
                            mendesak,
                            atau dana darurat untuk korban bencana.
                        </p>
                        <ul class="text-left text-sm text-gray-600 dark:text-gray-400 mb-8 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Fleksibel penggunaan
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Dampak maksimal
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Opsi anonim
                            </li>
                        </ul>
                        <a href="{{ route('donatur.buat-donasi-uang') }}"
                            class="inline-flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Donasi Uang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('donatur.dashboard') }}"
                    class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript for Popup -->
    @if(session('success'))
        <script>
            // Show popup when page loads
            document.addEventListener('DOMContentLoaded', function () {
                const popup = document.getElementById('success-popup');
                const popupContent = document.getElementById('popup-content');

                if (popup && popupContent) {
                    popup.style.display = 'block';

                    // Trigger animations
                    setTimeout(() => {
                        popup.classList.remove('opacity-0');
                        popup.classList.add('opacity-100');

                        popupContent.classList.remove('scale-95', 'opacity-0');
                        popupContent.classList.add('scale-100', 'opacity-100');
                    }, 10);

                    // Auto-close after 8 seconds
                    setTimeout(() => {
                        closePopup();
                    }, 8000);
                }
            });

            // Function to close popup
            function closePopup() {
                const popup = document.getElementById('success-popup');
                const popupContent = document.getElementById('popup-content');

                if (popup && popupContent) {
                    // Remove animations
                    popup.classList.remove('opacity-100');
                    popup.classList.add('opacity-0');

                    popupContent.classList.remove('scale-100', 'opacity-100');
                    popupContent.classList.add('scale-95', 'opacity-0');

                    // Hide after animation completes
                    setTimeout(() => {
                        popup.style.display = 'none';
                    }, 300);
                }
            }

            // Close popup when clicking outside
            document.addEventListener('click', function (e) {
                const popup = document.getElementById('success-popup');
                const popupContent = popup?.querySelector('.inline-block');

                if (popup && popup.style.display === 'block' && !popupContent?.contains(e.target)) {
                    closePopup();
                }
            });

            // Close popup with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closePopup();
                }
            });
        </script>
    @endif
</x-dashboard-layout>
