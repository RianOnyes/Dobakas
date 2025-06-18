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
<div id="{{ $id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-slate-100">
        <div class="mt-3">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <div class="mt-4 text-center">
                <h3 class="text-lg font-medium text-gray-900 ">{{ $title }}</h3>
                <div class="mt-2 px-2 py-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $message }}</p>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex items-center justify-center gap-3 mt-6">
                <button type="button" 
                        onclick="closeModal('{{ $id }}')"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                    {{ $cancelText }}
                </button>
                
                <button type="button" 
                        onclick="confirmAction('{{ $id }}')"
                        class="px-4 py-2 {{ $confirmClass }} text-white text-base font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition-colors">
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentForm = null;

    function showModal(modalId, form = null) {
        currentForm = form;
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.classList.add('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
        document.body.style.overflow = 'auto';
        currentForm = null;
    }

    function confirmAction(modalId) {
        if (currentForm) {
            currentForm.submit();
        }
        closeModal(modalId);
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
            const modalId = e.target.id;
            if (modalId && modalId.includes('Modal')) {
                closeModal(modalId);
            }
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('[id$="Modal"]');
            modals.forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    closeModal(modal.id);
                }
            });
        }
    });
</script> 
