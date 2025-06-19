# Donatur Dashboard - Code Snippets & Implementation Guide

This document contains all the important code snippets for the Donatur Dashboard functionality in the Donation Management System.

## 🚀 Recent Updates (Latest)
- ✅ **Fixed "Aktivitas Terbaru" table** - Now shows actual recent donations instead of hardcoded empty state
- ✅ **Added Dynamic Welcome Messages** - Personalized greetings based on user activity and donation status
- ✅ **Enhanced Statistics Cards** - More detailed and accurate donation counts by status
- ✅ **Smart Organization Suggestions** - AI-like recommendations based on user's donation categories
- ✅ **Personalized Activity Insights** - Contextual alerts and notifications based on donation status
- ✅ **Improved Timeline Display** - Visual timeline with status-specific icons and organization info
- ✅ **Responsive Design** - Better mobile and tablet experience

## Table of Contents
1. [Dashboard Home (Recent Activities)](#dashboard-home)
2. [Create Donation](#create-donation)
3. [View My Donations](#view-my-donations)
4. [Donation History](#donation-history)
5. [Search Organizations](#search-organizations)
6. [Donation Detail View](#donation-detail-view)
7. [Routes Configuration](#routes-configuration)

---

## Dashboard Home (Recent Activities) {#dashboard-home}

### Controller: `DonaturController::dashboard()`

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function dashboard()
{
    $user = auth()->user();

    $recentDonations = Donation::with(['claimedByOrganization'])
        ->forUser($user->id)
        ->latest()
        ->limit(5)
        ->get();

    $stats = [
        'total_donations' => $user->donations()->count(),
        'pending_donations' => $user->donations()->where('status', 'pending')->count(),
        'available_donations' => $user->donations()->where('status', 'available')->count(),
        'claimed_donations' => $user->donations()->where('status', 'claimed')->count(),
        'completed_donations' => $user->donations()->where('status', 'completed')->count(),
        'cancelled_donations' => $user->donations()->where('status', 'cancelled')->count(),
    ];

    $userCategories = $user->donations()
        ->whereNotNull('category')
        ->distinct()
        ->pluck('category')
        ->toArray();

    $suggestedOrganizations = collect();
    if (!empty($userCategories)) {
        $suggestedOrganizations = OrganizationDetail::with('user')
            ->withActiveUsers()
            ->where(function ($query) use ($userCategories) {
                foreach ($userCategories as $category) {
                    $query->orWhereJsonContains('needs_list', $category);
                }
            })
            ->limit(3)
            ->get();
    }

    $activityInsights = [
        'has_pending_donations' => $stats['pending_donations'] > 0,
        'has_recent_activity' => $recentDonations->count() > 0,
        'most_recent_status' => $recentDonations->first()?->status,
        'days_since_last_donation' => $recentDonations->first()?->created_at?->diffInDays(now()),
    ];

    return view('donatur.dashboard', compact(
        'recentDonations',
        'stats',
        'suggestedOrganizations',
        'activityInsights'
    ));
}
```

### View: Recent Activities Timeline

```blade
{{-- File: resources/views/donatur/dashboard.blade.php --}}

<!-- Recent Activities Section -->
@if($recentDonations->count() > 0)
    <div class="flow-root">
        <ul role="list" class="-mb-8">
            @foreach($recentDonations as $donation)
                <li class="relative pb-8">
                    @if (!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    @endif
                    <div class="relative flex space-x-3">
                        <div>
                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $donation->getStatusBadgeClass() }}">
                                @if($donation->status === 'pending')
                                    <svg class="h-5 w-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($donation->status === 'available')
                                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($donation->status === 'claimed')
                                    <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($donation->status === 'completed')
                                    <svg class="h-5 w-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-gray-900">
                                    <a href="{{ route('donatur.donation.show', $donation) }}" class="hover:underline font-medium">
                                        {{ $donation->title }}
                                    </a>
                                </p>
                                <p class="text-xs text-gray-500">{{ $donation->category }}</p>
                                @if($donation->claimedByOrganization)
                                    <p class="text-xs text-blue-600">Diklaim oleh {{ $donation->claimedByOrganization->name }}</p>
                                @endif
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $donation->getStatusBadgeClass() }}">
                                    {{ $donation->getStatusLabel() }}
                                </span>
                                <p class="mt-1 text-xs">{{ $donation->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <!-- Empty State -->
    <div class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas terbaru</h3>
        <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat donasi pertama Anda.</p>
        <div class="mt-6">
            <a href="{{ route('donatur.buat-donasi') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Buat Donasi
            </a>
        </div>
    </div>
@endif
```

### Dynamic Welcome Message

```blade
{{-- File: resources/views/donatur/dashboard.blade.php --}}

<!-- Welcome Message -->
<div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
    <div class="p-4 sm:p-6 text-gray-900">
        <h3 class="text-base sm:text-lg font-semibold mb-2">
            @if($activityInsights['days_since_last_donation'] !== null && $activityInsights['days_since_last_donation'] == 0)
                Selamat datang kembali, {{ auth()->user()->name }}! 🎉
            @elseif($activityInsights['days_since_last_donation'] !== null && $activityInsights['days_since_last_donation'] <= 7)
                Halo, {{ auth()->user()->name }}! 
            @else
                Selamat datang kembali, {{ auth()->user()->name }}!
            @endif
        </h3>
        @if($stats['total_donations'] == 0)
            <p class="text-sm sm:text-base text-gray-600">
                Selamat bergabung! Mulai perjalanan berbagi Anda dengan membuat donasi pertama.
            </p>
        @elseif($activityInsights['days_since_last_donation'] !== null && $activityInsights['days_since_last_donation'] == 0)
            <p class="text-sm sm:text-base text-gray-600">
                Terima kasih telah membuat donasi hari ini! Anda telah membantu {{ $stats['total_donations'] }} kali.
            </p>
        @elseif($stats['pending_donations'] > 0)
            <p class="text-sm sm:text-base text-gray-600">
                Anda memiliki {{ $stats['pending_donations'] }} donasi yang sedang menunggu verifikasi. Tim admin sedang memproses donasi Anda.
            </p>
        @elseif($stats['available_donations'] > 0)
            <p class="text-sm sm:text-base text-gray-600">
                Hebat! {{ $stats['available_donations'] }} donasi Anda tersedia untuk diklaim organisasi.
            </p>
        @elseif($stats['claimed_donations'] > 0)
            <p class="text-sm sm:text-base text-gray-600">
                {{ $stats['claimed_donations'] }} donasi Anda telah diklaim! Jangan lupa koordinasi untuk penyerahan.
            </p>
        @else
            <p class="text-sm sm:text-base text-gray-600">
                Siap membuat perubahan hari ini? Jelajahi permintaan donasi yang tersedia atau periksa riwayat donasi Anda.
            </p>
        @endif
    </div>
</div>
```

### Personalized Activity Insights

```blade
{{-- File: resources/views/donatur/dashboard.blade.php --}}

<!-- Personalized Insights -->
@if($activityInsights['has_recent_activity'])
    <div class="mb-4 sm:mb-6">
        @if($stats['available_donations'] > 0)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            Selamat! {{ $stats['available_donations'] }} donasi Anda telah tersedia untuk diklaim
                        </h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Organisasi dapat melihat dan mengklaim donasi Anda sekarang.</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($stats['claimed_donations'] > 0)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            {{ $stats['claimed_donations'] }} donasi Anda telah diklaim oleh organisasi
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Koordinasikan dengan organisasi untuk proses penyerahan.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif
```

### Smart Organization Suggestions

```blade
{{-- File: resources/views/donatur/dashboard.blade.php --}}

<!-- Suggested Organizations -->
@if($suggestedOrganizations->count() > 0)
    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
        <div class="p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2 sm:mb-0">
                    🎯 Organisasi yang Mungkin Tertarik</h3>
                <a href="{{ route('donatur.cari-bantuan') }}"
                    class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua</a>
            </div>
            <p class="text-sm text-gray-600 mb-4">Berdasarkan kategori donasi Anda sebelumnya</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($suggestedOrganizations as $org)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition-colors">
                        <h4 class="font-medium text-gray-900 text-sm">{{ $org->organization_name }}</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($org->description, 80) }}</p>
                        <div class="mt-2">
                            @if($org->needs_list && is_array($org->needs_list))
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($org->needs_list, 0, 3) as $need)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $need }}
                                        </span>
                                    @endforeach
                                    @if(count($org->needs_list) > 3)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            +{{ count($org->needs_list) - 3 }} lagi
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('donatur.organization.show', $org) }}" 
                               class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
```

### Dashboard Statistics Cards

```blade
<!-- Quick Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
    <!-- Total Donations -->
    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                    <dl>
                        <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Donasi</dt>
                        <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['total_donations'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Donations -->
    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                    <dl>
                        <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                        <dd class="text-lg sm:text-xl font-medium text-gray-900">
                            {{ $stats['pending_donations'] + $stats['available_donations'] + $stats['claimed_donations'] }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Donations -->
    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                    <dl>
                        <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Selesai</dt>
                        <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ $stats['completed_donations'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## Create Donation {#create-donation}

### Controller: `DonaturController::storeDonation()`

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function storeDonation(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string|max:255',
        'pickup_preference' => 'required|in:self_deliver,needs_pickup',
        'location' => 'nullable|string|max:500',
        'photos.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
    ]);

    $photoPaths = [];
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('donations', 'public');
            $photoPaths[] = $path;
        }
    }

    Donation::create([
        'user_id' => auth()->id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category' => $validated['category'],
        'pickup_preference' => $validated['pickup_preference'],
        'location' => $validated['location'] ?? auth()->user()->address ?? null,
        'photos' => $photoPaths,
        'status' => 'pending',
        'donation_type' => 'goods'
    ]);

    return redirect()->route('donatur.buat-donasi')->with('success', 'Donasi barang berhasil dibuat dan sedang menunggu verifikasi admin.');
}
```

### Money Donation Creation

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function storeMoneyDonation(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric|min:10000',
        'description' => 'nullable|string',
        'payment_method' => 'required|in:bank_transfer,e_wallet,cash',
        'anonymous' => 'nullable|boolean'
    ]);

    Donation::create([
        'user_id' => auth()->id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category' => 'Donasi Uang',
        'amount' => $validated['amount'],
        'payment_method' => $validated['payment_method'],
        'is_anonymous' => $validated['anonymous'] ?? false,
        'status' => 'pending',
        'donation_type' => 'money'
    ]);

    return redirect()->route('donatur.buat-donasi')->with('success', 'Donasi uang berhasil dibuat dan sedang menunggu verifikasi admin.');
}
```

---

## View My Donations {#view-my-donations}

### Controller: `DonaturController::donasiSaya()`

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function donasiSaya(Request $request)
{
    $status = $request->get('status');

    $donations = Donation::with(['claimedByOrganization', 'claimedByOrganization.organizationDetail'])
        ->forUser(auth()->id())
        ->active();

    if ($status) {
        $donations->byStatus($status);
    }

    $donations = $donations->latest()->paginate(9);

    return view('donatur.donasi-saya', compact('donations', 'status'));
}
```

### Model Scopes for Donations

```php
<?php
// File: app/Models/Donation.php

/**
 * Scope to get donations for a specific user
 */
public function scopeForUser($query, $userId)
{
    return $query->where('user_id', $userId);
}

/**
 * Scope to get active donations (not completed/cancelled)
 */
public function scopeActive($query)
{
    return $query->whereNotIn('status', ['completed', 'cancelled']);
}

/**
 * Scope to get donations by status
 */
public function scopeByStatus($query, $status)
{
    return $query->where('status', $status);
}

/**
 * Get status badge class
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
 * Get status label
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

---

## Donation History {#donation-history}

### Controller: `DonaturController::riwayat()`

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function riwayat(Request $request)
{
    $donations = Donation::with(['claimedByOrganization', 'claimedByOrganization.organizationDetail'])
        ->forUser(auth()->id())
        ->completed()
        ->latest()
        ->paginate(9);

    return view('donatur.riwayat', compact('donations'));
}
```

### Model Scope for Completed Donations

```php
<?php
// File: app/Models/Donation.php

/**
 * Scope to get completed donations (riwayat)
 */
public function scopeCompleted($query)
{
    return $query->whereIn('status', ['completed', 'cancelled']);
}
```

---

## Search Organizations {#search-organizations}

### Controller: `DonaturController::cariBantuan()`

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function cariBantuan(Request $request)
{
    $searchTerm = $request->get('search');
    $category = $request->get('category');

    $organizations = OrganizationDetail::with('user')
        ->withActiveUsers()
        ->search($searchTerm);


    if ($category) {
        $organizations->whereJsonContains('needs_list', $category);
    }

    $organizations = $organizations->paginate(9);


    $categories = OrganizationDetail::withActiveUsers()
        ->whereNotNull('needs_list')
        ->get()
        ->pluck('needs_list')
        ->flatten()
        ->unique()
        ->sort()
        ->values();

    return view('donatur.cari-bantuan', compact('organizations', 'searchTerm', 'category', 'categories'));
}
```

### Organization Model Scopes

```php
<?php
// File: app/Models/OrganizationDetail.php

/**
 * Scope to search organizations by name or needs
 */
public function scopeSearch($query, $searchTerm)
{
    if ($searchTerm) {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('organization_name', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%")
              ->orWhereJsonContains('needs_list', $searchTerm);
        });
    }
    return $query;
}

/**
 * Scope to get organizations that have active users (verified)
 */
public function scopeWithActiveUsers($query)
{
    return $query->whereHas('user', function ($q) {
        $q->where('role', 'organisasi')
          ->whereNotNull('email_verified_at');
    });
}
```

---

## Donation Detail View {#donation-detail-view}

### Controller: `DonaturController::showDonation()`

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function showDonation(Donation $donation)
{
    // Make sure this donation belongs to the authenticated user
    if ($donation->user_id !== auth()->id()) {
        abort(403);
    }

    $donation->load(['claimedByOrganization', 'claimedByOrganization.organizationDetail']);

    return view('donatur.donation-detail', compact('donation'));
}
```

### Cancel Donation Functionality

```php
<?php
// File: app/Http/Controllers/DonaturController.php

public function cancelDonation(Donation $donation)
{
    // Make sure this donation belongs to the authenticated user
    if ($donation->user_id !== auth()->id()) {
        abort(403);
    }

    // Only allow cancellation of pending or available donations
    if (!in_array($donation->status, ['pending', 'available'])) {
        return back()->with('error', 'Donasi tidak dapat dibatalkan pada status ini.');
    }

    $donation->update(['status' => 'cancelled']);

    return back()->with('success', 'Donasi berhasil dibatalkan.');
}
```

---

## Routes Configuration {#routes-configuration}

### Donatur Routes

```php
<?php
// File: routes/web.php

// Donatur Routes
Route::middleware(['auth', 'verified', 'donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DonaturController::class, 'dashboard'])->name('dashboard');
    
    // Organization Search
    Route::get('/cari-bantuan', [DonaturController::class, 'cariBantuan'])->name('cari-bantuan');
    Route::get('/organisasi/{organization}', [DonaturController::class, 'showOrganization'])->name('organization.show');
    
    // Donation Management
    Route::get('/buat-donasi', [DonaturController::class, 'selectDonationType'])->name('buat-donasi');
    Route::get('/buat-donasi/barang', [DonaturController::class, 'createDonation'])->name('buat-donasi-barang');
    Route::post('/buat-donasi/barang', [DonaturController::class, 'storeDonation'])->name('store-donasi-barang');
    Route::get('/buat-donasi/uang', [DonaturController::class, 'createMoneyDonation'])->name('buat-donasi-uang');
    Route::post('/buat-donasi/uang', [DonaturController::class, 'storeMoneyDonation'])->name('store-donasi-uang');
    
    // Donation Views
    Route::get('/donasi-saya', [DonaturController::class, 'donasiSaya'])->name('donasi-saya');
    Route::get('/riwayat', [DonaturController::class, 'riwayat'])->name('riwayat');
    Route::get('/donasi/{donation}', [DonaturController::class, 'showDonation'])->name('donation.show');
    Route::patch('/donasi/{donation}/cancel', [DonaturController::class, 'cancelDonation'])->name('donation.cancel');
});
```

---

## Key Features Summary

### ✅ Dashboard Features
- **✨ Dynamic Welcome Messages** - Personalized greetings based on user activity and donation status
- **📊 Real-time Statistics** - Live counts of donations by status with enhanced accuracy
- **⏰ Recent Activities Timeline** - Visual timeline of latest donations with status icons and organization info
- **🎯 Smart Organization Suggestions** - AI-like recommendations based on user's donation categories
- **🔔 Status-aware Insights** - Contextual alerts and notifications for different donation statuses
- **📱 Responsive Design** - Optimized for mobile, tablet, and desktop viewing

### ✅ Donation Management
- **📦 Create Goods Donations** - With photo uploads and detailed information
- **💰 Create Money Donations** - With payment method selection and anonymous options
- **👀 View Active Donations** - Filter by status with pagination and organization details
- **📜 Donation History** - Completed and cancelled donations with full timeline
- **🔍 Donation Details** - Full information with organization details and status tracking
- **❌ Cancel Donations** - For pending/available donations only with proper validation

### ✅ Organization Discovery
- **🔍 Search Organizations** - By name, description, or needs with advanced filtering
- **🏷️ Category Filtering** - Filter organizations by needed items and categories
- **👥 Organization Details** - View complete organization profiles with contact info
- **🤝 Smart Matching** - Organizations suggested based on donation categories and history

### ✅ Enhanced User Experience
- **🎨 Modern UI/UX** - Clean, intuitive interface with proper visual hierarchy
- **⚡ Real-time Updates** - Live status updates and activity tracking
- **📈 Progress Tracking** - Visual indicators for donation progress and completion
- **💡 Helpful Tips** - Contextual guidance and best practices for better donations
- **🔗 Easy Navigation** - Quick access to all major features from dashboard

### ✅ Technical Implementation
- **🔗 Eloquent Relationships** - Proper model associations and eager loading
- **⚡ Query Scopes** - Reusable, optimized query methods
- **📊 Status Management** - Comprehensive donation status tracking and transitions
- **📸 File Uploads** - Secure photo handling for donations with validation
- **✅ Form Validation** - Comprehensive validation for all inputs
- **🔒 Authorization** - Proper user permission checks and access control
- **📄 Pagination** - Efficient data loading with proper pagination
- **🎯 Smart Filtering** - Advanced filtering and search capabilities

### 🚀 Latest Enhancements
- **Fixed "Aktivitas Terbaru" Table** - Now displays actual recent donations instead of static content
- **Enhanced Statistics Display** - More detailed breakdown of donation statuses
- **Improved Organization Matching** - Better algorithm for suggesting relevant organizations
- **Added Contextual Insights** - Smart notifications based on current donation status
- **Better Timeline Visualization** - Enhanced activity timeline with proper status icons
- **Responsive Mobile Design** - Optimized layout for all screen sizes

This documentation provides a complete reference for all Donatur Dashboard functionality with production-ready code snippets that can be directly implemented or customized as needed. The dashboard now offers a fully dynamic, personalized experience that adapts to each user's donation activity and provides valuable insights to improve their donation experience. 