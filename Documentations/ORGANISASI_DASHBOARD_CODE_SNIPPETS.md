# Organisasi Dashboard - Code Snippets & Implementation Guide

This document contains all the important code snippets for the Organisasi Dashboard functionality in the Donation Management System.

## 🚀 Overview
The Organisasi Dashboard enables organizations to manage their donation activities, including claiming donations, managing their profile, tracking claimed donations, and creating donation requests.

## Table of Contents
1. [Main Dashboard](#main-dashboard)
2. [Organization Profile](#organization-profile)
3. [Donation Claiming](#donation-claiming)
4. [Claimed Donations Management](#claimed-donations-management)
5. [Donation Requests](#donation-requests)
6. [Warehouse Management](#warehouse-management)
7. [Modal Components](#modal-components)
8. [Routes Configuration](#routes-configuration)
9. [Model Relationships](#model-relationships)

---

## Main Dashboard

### Controller: `OrganisasiController::dashboard()`

```php
<?php
// File: app/Http/Controllers/OrganisasiController.php

public function dashboard()
{
    $user = auth()->user();
    
    $organizationDetail = $user->organizationDetail;
    
    $stats = [
        'total_claimed' => $user->claimedDonations()->count(),
        'pending_claims' => $user->claimedDonations()->where('status', 'claimed')->count(),
        'completed_donations' => $user->claimedDonations()->where('status', 'completed')->count(),
        'available_donations' => Donation::where('status', 'available')->count(),
    ];
    
    $recentClaims = $user->claimedDonations()
        ->with('user')
        ->latest()
        ->limit(5)
        ->get();
        
    $suggestedDonations = Donation::where('status', 'available')
        ->with('user')
        ->latest()
        ->limit(6)
        ->get();

    return view('organisasi.dashboard', compact(
        'organizationDetail', 
        'stats', 
        'recentClaims', 
        'suggestedDonations'
    ));
}
```

### Dashboard Statistics Display

```blade
{{-- File: resources/views/organisasi/dashboard.blade.php --}}

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Claimed -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Diklaim</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['total_claimed'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Claims -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Sedang Proses</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_claims'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Donations -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['completed_donations'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Donations -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Tersedia</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['available_donations'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## Organization Profile

### Controller: `OrganisasiController::profile()`

```php
<?php
// File: app/Http/Controllers/OrganisasiController.php

public function profile()
{
    $organizationDetail = auth()->user()->organizationDetail;
    
    return view('organisasi.profile', compact('organizationDetail'));
}

public function updateProfile(Request $request)
{
    $validated = $request->validate([
        'organization_name' => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'contact_phone' => 'required|string|max:20',
        'organization_address' => 'required|string|max:500',
        'description' => 'nullable|string',
        'needs_list' => 'nullable|array',
        'needs_list.*' => 'string|max:100',
        'document_url' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
    ]);

    $user = auth()->user();
    
    if ($request->hasFile('document_url')) {
        $documentPath = $request->file('document_url')->store('organization_documents', 'public');
        $validated['document_url'] = $documentPath;
    }

    $organizationDetail = $user->organizationDetail;
    if ($organizationDetail) {
        $organizationDetail->update($validated);
    } else {
        $validated['user_id'] = $user->id;
        OrganizationDetail::create($validated);
    }

    return back()->with('success', 'Profil organisasi berhasil diperbarui.');
}
```

### Profile Update Form

```blade
{{-- File: resources/views/organisasi/profile.blade.php --}}

<form method="POST" action="{{ route('organisasi.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PATCH')

    <!-- Organization Name -->
    <div>
        <label for="organization_name" class="block text-sm font-medium text-gray-700">Nama Organisasi</label>
        <input type="text" name="organization_name" id="organization_name" 
               value="{{ old('organization_name', $organizationDetail?->organization_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               required>
        @error('organization_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Contact Person -->
    <div>
        <label for="contact_person" class="block text-sm font-medium text-gray-700">Nama Penanggung Jawab</label>
        <input type="text" name="contact_person" id="contact_person" 
               value="{{ old('contact_person', $organizationDetail?->contact_person) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               required>
        @error('contact_person')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Contact Phone -->
    <div>
        <label for="contact_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
        <input type="tel" name="contact_phone" id="contact_phone" 
               value="{{ old('contact_phone', $organizationDetail?->contact_phone) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               required>
        @error('contact_phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Organization Address -->
    <div>
        <label for="organization_address" class="block text-sm font-medium text-gray-700">Alamat Organisasi</label>
        <textarea name="organization_address" id="organization_address" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  required>{{ old('organization_address', $organizationDetail?->organization_address) }}</textarea>
        @error('organization_address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Organisasi</label>
        <textarea name="description" id="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Ceritakan tentang organisasi Anda...">{{ old('description', $organizationDetail?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Needs List -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Kebutuhan Organisasi</label>
        <div class="mt-2 space-y-2" id="needs-container">
            @if($organizationDetail && $organizationDetail->needs_list)
                @foreach($organizationDetail->needs_list as $index => $need)
                    <div class="flex items-center space-x-2">
                        <input type="text" name="needs_list[]" value="{{ $need }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Contoh: Pakaian bekas, Buku pelajaran">
                        <button type="button" onclick="removeNeed(this)" class="text-red-500 hover:text-red-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            @else
                <div class="flex items-center space-x-2">
                    <input type="text" name="needs_list[]" value="{{ old('needs_list.0') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Contoh: Pakaian bekas, Buku pelajaran">
                    <button type="button" onclick="removeNeed(this)" class="text-red-500 hover:text-red-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
        <button type="button" onclick="addNeed()" class="mt-2 text-sm text-indigo-600 hover:text-indigo-500">
            + Tambah Kebutuhan
        </button>
    </div>

    <!-- Document Upload -->
    <div>
        <label for="document_url" class="block text-sm font-medium text-gray-700">Dokumen Organisasi</label>
        <input type="file" name="document_url" id="document_url" 
               accept=".pdf,.doc,.docx"
               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        <p class="mt-1 text-sm text-gray-500">Upload dokumen legalitas organisasi (PDF, DOC, DOCX max. 2MB)</p>
        @if($organizationDetail && $organizationDetail->document_url)
            <p class="mt-1 text-sm text-green-600">Dokumen sudah terupload</p>
        @endif
        @error('document_url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Simpan Profil
        </button>
    </div>
</form>
```

---

## Donation Claiming

### Controller: `OrganisasiController::claimDonation()`

```php
<?php
// File: app/Http/Controllers/OrganisasiController.php

public function claimDonation(Donation $donation)
{
    // Make sure this is an available donation
    if ($donation->status !== 'available') {
        return back()->with('error', "Donasi tidak tersedia untuk diklaim. Status saat ini: {$donation->status}");
    }

    // Make sure organization has complete profile
    $organizationDetail = auth()->user()->organizationDetail;
    if (!$organizationDetail) {
        return back()->with('error', 'Silakan lengkapi profil organisasi terlebih dahulu.');
    }

    $donation->update([
        'status' => 'claimed',
        'claimed_by_organization_id' => auth()->id()
    ]);

    return back()->with('success', 'Donasi berhasil diklaim. Silakan koordinasi dengan donatur untuk pengambilan.');
}
```

### Donation Detail View with Claim Button

```blade
{{-- File: resources/views/organisasi/donation-detail.blade.php --}}

<!-- Claim Action -->
<div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Klaim Donasi</h3>
        <p class="text-sm text-gray-600 mb-4">
            Dengan mengklaim donasi ini, Anda berkomitmen untuk mengambil dan menggunakan donasi
            sesuai dengan tujuan organisasi.
        </p>

        <form method="POST" action="{{ route('organisasi.donation.claim', $donation) }}" id="claimDetailForm">
            @csrf
            @method('PATCH')
            <button type="button"
                class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-berkah-teal hover:bg-berkah-hijau-gelap transition-colors"
                onclick="showModal('claimDetailModal', document.getElementById('claimDetailForm'))">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Klaim Donasi
            </button>
        </form>
    </div>
</div>
```

---

## Claimed Donations Management

### Controller: `OrganisasiController::claimedDonations()`

```php
<?php
// File: app/Http/Controllers/OrganisasiController.php

public function claimedDonations(Request $request)
{
    $status = $request->get('status');

    $donations = auth()->user()->claimedDonations()
        ->with('user');

    if ($status) {
        $donations->where('status', $status);
    }

    $donations = $donations->latest()->paginate(9);

    return view('organisasi.claimed-donations', compact('donations', 'status'));
}

public function completeDonation(Donation $donation)
{
    
    if ($donation->claimed_by_organization_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses ke donasi ini.');
    }

    if ($donation->status !== 'claimed') {
        return back()->with('error', 'Donasi hanya dapat diselesaikan dari status diklaim.');
    }

    $donation->update(['status' => 'completed']);

    return back()->with('success', 'Donasi telah ditandai sebagai selesai.');
}
```

### "Tandai Selesai" Button Implementation

```blade
{{-- File: resources/views/organisasi/claimed-donations.blade.php --}}

<!-- Action Buttons -->
<div class="flex gap-2">
    @if($donation->status === 'claimed')
        <form method="POST" action="{{ route('organisasi.donation.complete', $donation) }}" 
              class="flex-1" id="completeForm{{ $donation->id }}">
            @csrf
            @method('PATCH')
            <button type="button" 
                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm"
                onclick="showModal('completeModal{{ $donation->id }}', document.getElementById('completeForm{{ $donation->id }}'))">
                Tandai Selesai
            </button>
        </form>
    @else
        <div class="flex-1 px-4 py-2 bg-gray-100 text-gray-500 rounded-md text-center text-sm">
            Donasi Selesai
        </div>
    @endif
</div>

<!-- Modal for each donation -->
@foreach($donations as $donation)
    @if($donation->status === 'claimed')
        <x-confirmation-modal 
            id="completeModal{{ $donation->id }}"
            title="Konfirmasi Penyelesaian"
            message="Apakah donasi '{{ $donation->title }}' sudah selesai diambil dan diterima?"
            confirmText="Ya, Donasi Selesai"
            cancelText="Batal"
            confirmClass="bg-green-600 hover:bg-green-700"
        />
    @endif
@endforeach
```

---

## Warehouse Management

### Controller: `OrganisasiController::warehouseDonations()`

```php
<?php
// File: app/Http/Controllers/OrganisasiController.php

public function warehouseDonations(Request $request)
{
    $search = $request->get('search');
    $category = $request->get('category');

    $donations = Donation::where('status', 'available')
        ->with('user')
        ->when($search, function ($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        })
        ->when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })
        ->latest()
        ->paginate(12);

    $categories = Donation::where('status', 'available')
        ->whereNotNull('category')
        ->distinct()
        ->pluck('category')
        ->sort();

    return view('organisasi.warehouse-donations', compact(
        'donations',
        'search',
        'category',
        'categories'
    ));
}
```

---

## Donation Requests

### Controller: `OrganisasiController::storeRequest()`

```php
<?php
// File: app/Http/Controllers/OrganisasiController.php

public function storeRequest(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string|max:255',
        'urgency_level' => 'required|in:low,medium,high',
        'quantity_needed' => 'nullable|integer|min:1',
        'location' => 'nullable|string|max:500',
        'needed_by' => 'nullable|date|after:today'
    ]);

    $organizationDetail = auth()->user()->organizationDetail;
    if (!$organizationDetail) {
        return back()->with('error', 'Silakan lengkapi profil organisasi terlebih dahulu.');
    }

    DonationRequest::create([
        'organization_id' => auth()->id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category' => $validated['category'],
        'urgency_level' => $validated['urgency_level'],
        'quantity_needed' => $validated['quantity_needed'],
        'location' => $validated['location'] ?? $organizationDetail->organization_address,
        'needed_by' => $validated['needed_by'],
        'status' => 'active'
    ]);

    return redirect()->route('organisasi.requests')->with('success', 'Permintaan donasi berhasil dibuat.');
}

public function updateRequestStatus(DonationRequest $request, Request $httpRequest)
{

    if ($request->organization_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses ke permintaan ini.');
    }

    $validated = $httpRequest->validate([
        'status' => 'required|in:active,fulfilled,cancelled'
    ]);

    $request->update(['status' => $validated['status']]);

    $statusLabel = match ($validated['status']) {
        'fulfilled' => 'terpenuhi',
        'cancelled' => 'dibatalkan', 
        'active' => 'diaktifkan kembali',
        default => 'diperbarui'
    };

    return back()->with('success', "Permintaan berhasil {$statusLabel}.");
}
```

---

## Modal Components

### Confirmation Modal Component

```blade
{{-- File: resources/views/components/confirmation-modal.blade.php --}}

@props([
    'id' => 'confirmationModal',
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin ingin melanjutkan?',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'confirmClass' => 'bg-red-600 hover:bg-red-700'
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
```

### Modal JavaScript Implementation

```javascript
// File: resources/views/organisasi/claimed-donations.blade.php (bottom of file)

<script>
    function showModal(modalId, form) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            modal.dataset.form = form.id;
        }
    }

    // Handle modal confirmations
    document.addEventListener('click', function (e) {
        if (e.target.matches('[data-action="confirm"]')) {
            const modal = e.target.closest('.modal');
            const formId = modal?.dataset.form;
            if (formId) {
                document.getElementById(formId).submit();
            }
        } else if (e.target.matches('[data-action="cancel"]') || e.target.matches('.modal-overlay')) {
            const modal = e.target.closest('.modal') || e.target;
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal[style*="flex"]');
            modals.forEach(modal => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }
    });
</script>
```

---

## Routes Configuration

```php
<?php
// File: routes/web.php

// Organisasi Routes
Route::middleware(['auth', 'verified', 'organisasi'])->prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/dashboard', [OrganisasiController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [OrganisasiController::class, 'profile'])->name('profile');
    Route::patch('/profile', [OrganisasiController::class, 'updateProfile'])->name('profile.update');
    
    // Claimed Donations Management
    Route::get('/donasi-diklaim', [OrganisasiController::class, 'claimedDonations'])->name('claimed-donations');
    Route::patch('/donasi/{donation}/complete', [OrganisasiController::class, 'completeDonation'])->name('donation.complete');
    
    // Warehouse Donations Browsing
    Route::get('/gudang-admin', [OrganisasiController::class, 'warehouseDonations'])->name('warehouse-donations');
    Route::get('/donasi/{donation}', [OrganisasiController::class, 'showDonation'])->name('donation.show');
    Route::patch('/donasi/{donation}/claim', [OrganisasiController::class, 'claimDonation'])->name('donation.claim');
    
    // Request Management
    Route::get('/permintaan', [OrganisasiController::class, 'requests'])->name('requests');
    Route::get('/buat-permintaan', [OrganisasiController::class, 'createRequest'])->name('create-request');
    Route::post('/buat-permintaan', [OrganisasiController::class, 'storeRequest'])->name('store-request');
    Route::get('/permintaan/{request}', [OrganisasiController::class, 'showRequest'])->name('request.show');
    Route::patch('/permintaan/{request}/status', [OrganisasiController::class, 'updateRequestStatus'])->name('request.status');
    Route::delete('/permintaan/{request}', [OrganisasiController::class, 'deleteRequest'])->name('request.delete');
});
```

---

## Model Relationships

### User Model Relationships for Organizations

```php
<?php
// File: app/Models/User.php

/**
 * Get the organization detail associated with the user.
 */
public function organizationDetail()
{
    return $this->hasOne(OrganizationDetail::class);
}

/**
 * Get the donations claimed by this user (if organisasi).
 */
public function claimedDonations()
{
    return $this->hasMany(Donation::class, 'claimed_by_organization_id');
}

/**
 * Get the donation requests made by this user (if organisasi).
 */
public function donationRequests()
{
    return $this->hasMany(DonationRequest::class, 'organization_id');
}
```

### Donation Model Status Methods

```php
<?php
// File: app/Models/Donation.php

/**
 * Get status badge class.
 */
public function getStatusBadgeClass()
{
    return match($this->status) {
        'pending' => 'bg-yellow-100 text-yellow-800',
        'available' => 'bg-green-100 text-green-800',
        'claimed' => 'bg-blue-100 text-blue-800',
        'completed' => 'bg-gray-100 text-gray-800',
        'cancelled' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800'
    };
}

/**
 * Get status label.
 */
public function getStatusLabel()
{
    return match($this->status) {
        'pending' => 'Menunggu Verifikasi',
        'available' => 'Tersedia',
        'claimed' => 'Sudah Diklaim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => 'Unknown'
    };
}
```

### DonationRequest Model Status Methods

```php
<?php
// File: app/Models/DonationRequest.php

/**
 * Get status badge class.
 */
public function getStatusBadgeClass()
{
    return match ($this->status) {
        'active' => 'bg-green-100 text-green-800',
        'fulfilled' => 'bg-blue-100 text-blue-800',
        'cancelled' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800'
    };
}

/**
 * Get status label.
 */
public function getStatusLabel()
{
    return match ($this->status) {
        'active' => 'Aktif',
        'fulfilled' => 'Terpenuhi', 
        'cancelled' => 'Dibatalkan',
        default => 'Unknown'
    };
}

/**
 * Get urgency level badge class.
 */
public function getUrgencyBadgeClass()
{
    return match ($this->urgency_level) {
        'low' => 'bg-gray-100 text-gray-800',
        'medium' => 'bg-yellow-100 text-yellow-800',
        'high' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800'
    };
}
```

---

## Key Implementation Notes

### 🔧 Status Flow
- **available** → **claimed** → **completed**
- Organizations can only claim donations with `status = 'available'`
- Organizations can only complete donations they have claimed

### 🔐 Security Features
- Organizations can only access their own claimed donations
- Organizations can only modify their own donation requests
- Profile completion is required before claiming

### 🎯 User Experience
- Modern modal confirmations for important actions
- Responsive design for all screen sizes
- Real-time status updates and feedback
- Search and filter functionality

### 🚀 Performance Optimizations
- Eager loading relationships (`with('user')`)
- Pagination for large datasets
- Efficient query filtering
- Minimal JavaScript for modal functionality

---

*Last Updated: December 2024*
*This document covers the complete organisasi dashboard functionality including latest modal improvements and bug fixes.* 