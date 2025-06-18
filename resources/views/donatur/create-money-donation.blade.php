<x-dashboard-layout>
    <x-slot name="header">Donasi Uang</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Info -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buat Donasi Uang</h3>
                    <p class="text-gray-600">
                        Donasi uang Anda akan disalurkan kepada organisasi yang membutuhkan untuk membantu operasional, 
                        pembelian kebutuhan mendesak, atau bantuan darurat. Tim admin akan memverifikasi donasi Anda terlebih dahulu.
                    </p>
                </div>
            </div>

            <!-- Money Donation Form -->
            <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('donatur.store-donasi-uang') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Donation Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Donasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Contoh: Bantuan Dana untuk Korban Bencana Alam"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Donation Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Donasi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" 
                                       id="amount" 
                                       name="amount" 
                                       value="{{ old('amount') }}"
                                       min="10000"
                                       step="1000"
                                       placeholder="50000"
                                       class="w-full pl-12 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                       required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Minimal donasi Rp 10.000
                            </p>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quick Amount Buttons -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Atau pilih nominal cepat:
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <button type="button" onclick="setAmount(25000)" 
                                        class="amount-btn bg-gray-200 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                    Rp 25.000
                                </button>
                                <button type="button" onclick="setAmount(50000)" 
                                        class="amount-btn bg-gray-200 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                    Rp 50.000
                                </button>
                                <button type="button" onclick="setAmount(100000)" 
                                        class="amount-btn bg-gray-200 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                    Rp 100.000
                                </button>
                                <button type="button" onclick="setAmount(200000)" 
                                        class="amount-btn bg-gray-200 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 py-2 px-4 rounded-md text-sm font-medium transition-colors">
                                    Rp 200.000
                                </button>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <input type="radio" 
                                           id="bank_transfer" 
                                           name="payment_method" 
                                           value="bank_transfer" 
                                           {{ old('payment_method', 'bank_transfer') === 'bank_transfer' ? 'checked' : '' }}
                                           class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    <div class="ml-3">
                                        <label for="bank_transfer" class="text-sm font-medium text-gray-700">
                                            Transfer Bank
                                        </label>
                                        <p class="text-sm text-gray-500">
                                            Transfer melalui rekening bank yang akan diberikan setelah konfirmasi
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <input type="radio" 
                                           id="e_wallet" 
                                           name="payment_method" 
                                           value="e_wallet" 
                                           {{ old('payment_method') === 'e_wallet' ? 'checked' : '' }}
                                           class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    <div class="ml-3">
                                        <label for="e_wallet" class="text-sm font-medium text-gray-700">
                                            E-Wallet (GoPay/OVO/DANA)
                                        </label>
                                        <p class="text-sm text-gray-500">
                                            Transfer melalui dompet digital
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <input type="radio" 
                                           id="cash" 
                                           name="payment_method" 
                                           value="cash" 
                                           {{ old('payment_method') === 'cash' ? 'checked' : '' }}
                                           class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    <div class="ml-3">
                                        <label for="cash" class="text-sm font-medium text-gray-700">
                                            Tunai Langsung
                                        </label>
                                        <p class="text-sm text-gray-500">
                                            Serahkan langsung ke kantor admin Berkah BaBe
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Pesan atau Catatan (Opsional)
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Tambahkan pesan atau doa untuk penerima donasi..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Anonymous Option -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <input type="checkbox" 
                                       id="anonymous" 
                                       name="anonymous" 
                                       value="1"
                                       {{ old('anonymous') ? 'checked' : '' }}
                                       class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <div class="ml-3">
                                    <label for="anonymous" class="text-sm font-medium text-gray-700">
                                        Donasi Anonim
                                    </label>
                                    <p class="text-sm text-gray-500">
                                        Centang jika Anda tidak ingin nama Anda ditampilkan sebagai donatur
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('donatur.buat-donasi') }}" 
                               class="bg-gray-200 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                                Kembali
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                Buat Donasi Uang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setAmount(amount) {
            const amountInput = document.getElementById('amount');
            amountInput.value = amount;
            
            // Remove active class from all buttons
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-100', 'text-indigo-700');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });

            // Add active class to clicked button
            event.target.classList.remove('bg-gray-200', 'text-gray-700');
            event.target.classList.add('bg-indigo-100', 'text-indigo-700');
        }

        // Format number input with thousand separators
        document.getElementById('amount').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
</x-dashboard-layout> 
