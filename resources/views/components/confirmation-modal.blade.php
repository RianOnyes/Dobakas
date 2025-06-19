@props([
    'id' => 'confirmationModal',
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin ingin melanjutkan?',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'confirmClass' => 'bg-red-600 hover:bg-red-700',
    'action' => ''
])

<!-- Confirmation Modal -->
<div id="{{ $id }}" class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center p-4 z-50 modal-overlay" style="display: none;">
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6">
        <!-- Icon -->
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 mb-4">
            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
        </div>
        
        <!-- Content -->
        <div class="text-center mb-5">
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $title }}</h3>
            <p class="text-sm text-gray-500">{{ $message }}</p>
        </div>
        
        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="button" 
                    data-action="cancel"
                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                {{ $cancelText }}
            </button>
            
            <button type="button" 
                    data-action="confirm"
                    class="flex-1 px-4 py-2 text-sm font-medium {{ $confirmClass }} text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>

 
