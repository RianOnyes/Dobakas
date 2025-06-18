# Berkah BaBe - Dashboard Code Snippets
## Donatur | Organisasi | Admin Dashboard Operations

---

## 🏠 **Dashboard Overview**

This documentation provides code snippets for dashboard operations specific to each user role in the Berkah BaBe donation management system.

### **User Roles**
- **Donatur**: Create donations, search organizations, manage donation history
- **Organisasi**: Claim donations, manage requests, update organization profile
- **Admin**: Manage users, approve donations, view statistics, system administration

---

## 👤 **DONATUR DASHBOARD**

### **Dashboard Controller - Statistics & Quick Actions**
```php
// app/Http/Controllers/DonaturController.php
public function dashboard()
{
    return view('donatur.dashboard');
}
```

### **Dashboard View - Stats Display**
```php
<!-- resources/views/donatur/dashboard.blade.php -->
<!-- Quick Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
    <div class="bg-slate-100 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-8 sm:w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                    <dl>
                        <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Donasi</dt>
                        <dd class="text-lg sm:text-xl font-medium text-gray-900">
                            {{ auth()->user()->donations()->count() }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional stat cards... -->
</div>
```

### **Making a Donation - Create Form**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Show the create donation form
 */
public function createDonation()
{
    return view('donatur.create-donation');
}

/**
 * Store a new donation
 */
public function storeDonation(Request $request)
{
    // Validation rules
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string|max:255',
        'pickup_preference' => 'required|in:self_deliver,needs_pickup',
        'location' => 'nullable|string|max:500',
        'photos.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
    ]);

    // Handle photo uploads
    $photoPaths = [];
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('donations', 'public');
            $photoPaths[] = $path;
        }
    }

    // Create donation record
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

    return redirect()->route('donatur.buat-donasi')
                   ->with('success', 'Donasi barang berhasil dibuat dan sedang menunggu verifikasi admin.');
}
```

### **Creating Money Donation**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Store a new money donation
 */
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

    return redirect()->route('donatur.buat-donasi')
                   ->with('success', 'Donasi uang berhasil dibuat dan sedang menunggu verifikasi admin.');
}
```

### **Viewing My Donations**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Show user's donations with filtering
 */
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

### **Searching Organizations**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Search organizations needing help
 */
public function cariBantuan(Request $request)
{
    $searchTerm = $request->get('search');
    $category = $request->get('category');

    $organizations = OrganizationDetail::with('user')
        ->withActiveUsers()
        ->search($searchTerm);

    // Filter by category if needed - search in needs_list array
    if ($category) {
        $organizations->whereJsonContains('needs_list', $category);
    }

    $organizations = $organizations->paginate(9);

    // Get unique categories from all organizations for filter
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

---

## 🏢 **ORGANISASI DASHBOARD**

### **Dashboard Controller - Organization Statistics**
```php
// app/Http/Controllers/OrganisasiController.php
public function dashboard()
{
    $user = auth()->user();
    
    // Get organization details if exists
    $organizationDetail = $user->organizationDetail;
    
    // Get statistics for this organization
    $stats = [
        'total_claimed' => $user->claimedDonations()->count(),
        'pending_claims' => $user->claimedDonations()->where('status', 'claimed')->count(),
        'completed_donations' => $user->claimedDonations()->where('status', 'completed')->count(),
        'available_donations' => Donation::where('status', 'available')->count(),
    ];
    
    // Get recent claimed donations
    $recentClaims = $user->claimedDonations()
        ->with('user')
        ->latest()
        ->limit(5)
        ->get();
        
    // Get available donations that might interest this organization
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

### **Dashboard View - Organization Stats**
```php
<!-- resources/views/organisasi/dashboard.blade.php -->
<!-- Quick Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
    <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
        <div class="p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 bg-berkah-secondary rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                    <dl>
                        <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Donasi Diklaim</dt>
                        <dd class="text-lg sm:text-xl font-medium text-gray-900">
                            {{ number_format($stats['total_claimed']) }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional stat cards... -->
</div>
```

### **Claiming a Donation**
```php
// app/Http/Controllers/OrganisasiController.php
/**
 * Claim a donation from admin warehouse
 */
public function claimDonation(Donation $donation)
{
    // Make sure this is an available donation
    if ($donation->status !== 'available') {
        return back()->with('error', 'Donasi tidak tersedia untuk diklaim.');
    }

    // Make sure organization has complete profile
    $organizationDetail = auth()->user()->organizationDetail;
    if (!$organizationDetail) {
        return back()->with('error', 'Silakan lengkapi profil organisasi terlebih dahulu.');
    }

    // Update donation status and assign to organization
    $donation->update([
        'status' => 'claimed',
        'claimed_by_organization_id' => auth()->id()
    ]);

    return back()->with('success', 'Donasi berhasil diklaim. Silakan koordinasi dengan donatur untuk pengambilan.');
}

/**
 * Mark donation as completed
 */
public function completeDonation(Donation $donation)
{
    // Authorization check
    if ($donation->claimed_by_organization_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses ke donasi ini.');
    }

    // Business logic check
    if ($donation->status !== 'claimed') {
        return back()->with('error', 'Donasi hanya dapat diselesaikan dari status diklaim.');
    }

    $donation->update(['status' => 'completed']);

    return back()->with('success', 'Donasi telah ditandai sebagai selesai.');
}
```

### **Creating Donation Requests**
```php
// app/Http/Controllers/OrganisasiController.php
/**
 * Store a new donation request
 */
public function storeRequest(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string|max:255',
        'urgency_level' => 'required|in:low,medium,high',
        'quantity_needed' => 'nullable|integer|min:1',
        'location' => 'nullable|string|max:500',
        'needed_by' => 'nullable|date|after:today',
        'tags' => 'nullable|array',
        'tags.*' => 'string|max:50'
    ]);

    // Make sure organization has complete profile
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
        'tags' => $validated['tags'] ?? [],
        'status' => 'active'
    ]);

    return redirect()->route('organisasi.requests')->with('success', 'Permintaan donasi berhasil dibuat.');
}
```

### **Updating Organization Profile**
```php
// app/Http/Controllers/OrganisasiController.php
/**
 * Update organization profile
 */
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
    
    // Handle file upload
    if ($request->hasFile('document_url')) {
        $documentPath = $request->file('document_url')->store('organization_documents', 'public');
        $validated['document_url'] = $documentPath;
    }

    // Update or create organization detail
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

### **Managing Claimed Donations**
```php
// app/Http/Controllers/OrganisasiController.php
/**
 * Show claimed donations with status filtering
 */
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

/**
 * Browse available donations in admin warehouse
 */
public function warehouseDonations(Request $request)
{
    $search = $request->get('search');
    $category = $request->get('category');

    $donations = Donation::where('status', 'available')
        ->with('user')
        ->when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        })
        ->when($category, function($query) use ($category) {
            return $query->where('category', $category);
        })
        ->latest()
        ->paginate(12);

    // Get available categories
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

## 👑 **ADMIN DASHBOARD**

### **Dashboard Controller - System Statistics**
```php
// app/Http/Controllers/AdminController.php
public function dashboard(): View
{
    $stats = [
        'total_users' => User::count(),
        'total_donatur' => User::where('role', 'donatur')->count(),
        'total_organisasi' => User::where('role', 'organisasi')->count(),
        'pending_verification' => User::where('is_verified', false)->count(),
    ];

    $recent_users = User::latest()->take(5)->get();

    return view('admin.dashboard', compact('stats', 'recent_users'));
}
```

### **Dashboard View - Admin Stats Cards**
```php
<!-- resources/views/admin/dashboard.blade.php -->
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
    <x-dashboard.stat-card title="Total Pengguna" :value="$stats['total_users']" icon="users" />
    <x-dashboard.stat-card title="Donatur" :value="$stats['total_donatur']" icon="donations" />
    <x-dashboard.stat-card title="Organisasi" :value="$stats['total_organisasi']" icon="organizations" />
    <x-dashboard.stat-card title="Menunggu Verifikasi" :value="$stats['pending_verification']" icon="pending" />
</div>

<!-- Recent Users Table -->
<div class="hidden sm:block overflow-x-auto">
    <table class="min-w-full divide-y divide-berkah-accent/20">
        <thead class="bg-berkah-cream/30">
            <tr>
                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
            </tr>
        </thead>
        <tbody class="bg-white/50 divide-y divide-berkah-accent/10">
            @foreach($recent_users as $user)
                <tr class="hover:bg-berkah-cream/30 transition-colors">
                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $user->name }}
                    </td>
                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->email }}
                    </td>
                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($user->role === 'admin') bg-berkah-primary text-white
                                        @elseif($user->role === 'donatur') bg-berkah-secondary text-white
                                        @else bg-berkah-accent text-berkah-primary @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_verified ? 'bg-berkah-secondary text-white' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $user->is_verified ? 'Terverifikasi' : 'Menunggu' }}
                        </span>
                    </td>
                    <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

### **User Management**
```php
// app/Http/Controllers/AdminController.php
/**
 * Show users management page
 */
public function users(): View
{
    $users = User::paginate(15);
    return view('admin.users', compact('users'));
}

/**
 * Verify user account
 */
public function verifyUser(User $user)
{
    $user->update(['is_verified' => true]);
    return back()->with('success', 'User verified successfully');
}

/**
 * Delete user account
 */
public function deleteUser(User $user)
{
    if ($user->isAdmin()) {
        return back()->with('error', 'Tidak dapat menghapus akun admin.');
    }

    $user->delete();
    return back()->with('success', 'Pengguna berhasil dihapus.');
}
```

### **Donation Management**
```php
// app/Http/Controllers/AdminController.php
/**
 * Show donations management page
 */
public function donations(Request $request): View
{
    $status = $request->get('status');
    $search = $request->get('search');

    $donations = Donation::with(['user', 'claimedByOrganization'])
        ->when($status, function($query) use ($status) {
            return $query->where('status', $status);
        })
        ->when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        })
        ->latest()
        ->paginate(15);

    return view('admin.donations', compact('donations', 'status', 'search'));
}

/**
 * Update donation status
 */
public function updateDonationStatus(Donation $donation, Request $request)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,available,claimed,completed,cancelled'
    ]);

    $donation->update(['status' => $validated['status']]);

    return back()->with('success', 'Status donasi berhasil diperbarui.');
}

/**
 * Show donation detail
 */
public function showDonation(Donation $donation): View
{
    $donation->load(['user', 'claimedByOrganization.organizationDetail']);
    return view('admin.donation-detail', compact('donation'));
}
```

### **Organization Management**
```php
// app/Http/Controllers/AdminController.php
/**
 * Show organizations management page
 */
public function organizations(Request $request): View
{
    $search = $request->get('search');
    $status = $request->get('status');

    // Get all organization users, whether they have completed organization details or not
    $organizationUsers = User::with('organizationDetail')
        ->where('role', 'organisasi')
        ->when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('organizationDetail', function($orgQuery) use ($search) {
                      $orgQuery->where('organization_name', 'like', "%{$search}%")
                               ->orWhere('description', 'like', "%{$search}%");
                  });
            });
        })
        ->when($status === 'verified', function($query) {
            return $query->whereNotNull('email_verified_at');
        })
        ->when($status === 'unverified', function($query) {
            return $query->whereNull('email_verified_at');
        })
        ->latest()
        ->paginate(15);

    return view('admin.organizations', compact('organizationUsers', 'search', 'status'));
}

/**
 * Show organization detail
 */
public function showOrganization(OrganizationDetail $organization): View
{
    $organization->load(['user']);
    
    // Get donations claimed by this organization
    $claimedDonations = Donation::where('claimed_by_organization_id', $organization->user_id)
        ->with('user')
        ->latest()
        ->limit(10)
        ->get();

    return view('admin.organization-detail', compact('organization', 'claimedDonations'));
}
```

### **Advanced Statistics with Filtering**
```php
// app/Http/Controllers/AdminController.php
/**
 * Show statistics page with filtering
 */
public function statistics(Request $request): View
{
    // Get filter parameters
    $period = $request->get('period', 'all'); // all, today, week, month, year, custom
    $startDate = $request->get('start_date');
    $endDate = $request->get('end_date');

    // Apply date filtering
    $query = $this->applyDateFilter($period, $startDate, $endDate);

    // Basic statistics
    $stats = [
        'total_users' => User::count(),
        'total_donatur' => User::where('role', 'donatur')->count(),
        'total_organisasi' => User::where('role', 'organisasi')->count(),
        'new_users_this_period' => $query['users']->count(),
        'total_donations' => $query['donations']->count(),
        'pending_donations' => $query['donations']->where('status', 'pending')->count(),
        'available_donations' => $query['donations']->where('status', 'available')->count(),
        'completed_donations' => $query['donations']->where('status', 'completed')->count(),
    ];

    // Monthly donation trends
    $monthlyDonations = $this->getMonthlyDonations($query['donations']);

    // Top categories
    $topCategories = $query['donations']
        ->selectRaw('category, COUNT(*) as count')
        ->whereNotNull('category')
        ->groupBy('category')
        ->orderByDesc('count')
        ->limit(10)
        ->get();

    return view('admin.statistics', compact(
        'stats', 
        'monthlyDonations', 
        'topCategories',
        'period',
        'startDate',
        'endDate'
    ));
}

/**
 * Export statistics to CSV
 */
public function exportStatistics(Request $request)
{
    $period = $request->get('period', 'all');
    $startDate = $request->get('start_date');
    $endDate = $request->get('end_date');

    $query = $this->applyDateFilter($period, $startDate, $endDate);

    $filename = 'statistik_donasi_' . now()->format('Y-m-d_H-i-s') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function() use ($query, $period, $startDate, $endDate) {
        $file = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header information
        fputcsv($file, ['LAPORAN STATISTIK DONASI BARANG BEKAS']);
        fputcsv($file, ['Tanggal Export:', now()->format('d/m/Y H:i:s')]);
        fputcsv($file, ['Periode:', $this->getPeriodLabel($period, $startDate, $endDate)]);
        fputcsv($file, []);

        // Summary statistics
        fputcsv($file, ['RINGKASAN STATISTIK']);
        fputcsv($file, ['Kategori', 'Jumlah']);
        fputcsv($file, ['Total Pengguna', $query['users']->count()]);
        fputcsv($file, ['Total Donatur', $query['users']->where('role', 'donatur')->count()]);
        fputcsv($file, ['Total Organisasi', $query['users']->where('role', 'organisasi')->count()]);
        fputcsv($file, ['Total Donasi', $query['donations']->count()]);

        // Export detailed data...
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
```

---

## 🔧 **Shared Dashboard Components**

### **Stat Card Component**
```php
<!-- resources/views/components/dashboard/stat-card.blade.php -->
@props(['title', 'value', 'icon'])

<div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-lg sm:rounded-lg border border-berkah-accent/20">
    <div class="p-4 sm:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 bg-berkah-secondary rounded-lg flex items-center justify-center">
                    @if($icon === 'users')
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                    @elseif($icon === 'donations')
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"></path>
                        </svg>
                    @endif
                </div>
            </div>
            <div class="ml-3 sm:ml-5 w-0 flex-1 min-w-0">
                <dl>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                    <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ number_format($value) }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
```

### **Dashboard Layout Component**
```php
<!-- resources/views/components/dashboard-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
```

---

## 🚀 **Quick Commands for Dashboard Development**

```bash
# Create new controller
php artisan make:controller DashboardController

# Create dashboard view
php artisan make:view dashboard.index

# Create dashboard component
php artisan make:component Dashboard/StatCard

# Test dashboard routes
php artisan route:list --name=dashboard

# Clear cache for development
php artisan optimize:clear

# Run with real-time updates
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 📊 **Dashboard Testing**

```bash
# Test user creation
curl -X POST http://localhost:8000/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password","role":"donatur"}'

# Test dashboard access
curl -X GET http://localhost:8000/donatur/dashboard \
  -H "Authorization: Bearer {token}"

# Test donation creation
curl -X POST http://localhost:8000/donatur/buat-donasi \
  -H "Authorization: Bearer {token}" \
  -F "title=Test Donation" \
  -F "category=Electronics" \
  -F "pickup_preference=self_deliver"
```

This documentation provides comprehensive dashboard code snippets for all three user roles, showing the actual implementation of key features like donation creation, claiming, user management, and statistics in the Berkah BaBe system. 