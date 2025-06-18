# Berkah BaBe - Code Snippets Documentation
## Database Migrations | Seeders | Login | CRUD API

---

## 🗄️ **Database Migrations**

### **Users Table Migration**
```php
// database/migrations/0001_01_01_000000_create_users_table.php
public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->enum('role', ['donatur', 'organisasi', 'admin'])->default('donatur');
        $table->boolean('is_verified')->default(false); 
        $table->timestamps(); 
    });

    Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    });

    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}
```

### **Donations Table Migration**
```php
// database/migrations/2025_06_05_180842_create_donations_table.php
public function up(): void
{
    Schema::create('donations', function (Blueprint $table) {
        $table->id();
        
        // Foreign key to users table (donatur)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->string('title'); 
        $table->text('description')->nullable(); 
        $table->string('category'); 
        $table->json('photos')->nullable(); 
        
        // Status: 'pending', 'available', 'claimed', 'completed', 'cancelled'
        $table->enum('status', ['pending', 'available', 'claimed', 'completed', 'cancelled'])
              ->default('pending');
              
        // Pickup preference: 'self_deliver', 'needs_pickup'
        $table->enum('pickup_preference', ['self_deliver', 'needs_pickup'])
              ->default('self_deliver');
              
        $table->string('location')->nullable(); 
        
        // Foreign key to users table (Organization that claims donation)
        $table->foreignId('claimed_by_organization_id')->nullable()
              ->constrained('users')->onDelete('set null');
              
        $table->timestamps();
    });
}
```

### **Organization Details Migration**
```php
// database/migrations/2025_06_05_180904_create_organization_details_table.php
public function up(): void
{
    Schema::create('organization_details', function (Blueprint $table) {
        $table->id();
        
        // Foreign key to users table (organization)
        $table->foreignId('user_id')->constrained('users')->unique()->onDelete('cascade');
        
        $table->string('organization_name'); 
        $table->string('contact_person')->nullable(); 
        $table->string('contact_phone')->nullable(); 
        $table->string('organization_address')->nullable(); 
        $table->text('description')->nullable(); 
        $table->json('needs_list')->nullable(); // JSON array of needed items
        $table->string('document_url')->nullable(); // Legal documents
        
        $table->timestamps();
    });
}
```

### **Running Migrations**
```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:fresh

# Run migrations with seeders
php artisan migrate:fresh --seed
```

---

## 🌱 **Database Seeders**

### **Main DatabaseSeeder**
```php
// database/seeders/DatabaseSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call specific seeders
        $this->call([
            UserSeeder::class,
        ]);
    }
}
```

### **UserSeeder - Creating Test Users**
```php
// database/seeders/UserSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@donasibarang.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create Donatur User
        User::create([
            'name' => 'John Donatur',
            'email' => 'donatur@donasibarang.com',
            'password' => Hash::make('password123'),
            'role' => 'donatur',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create Organisasi User
        User::create([
            'name' => 'Panti Asuhan Harapan',
            'email' => 'organisasi@donasibarang.com',
            'password' => Hash::make('password123'),
            'role' => 'organisasi',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create additional test users
        User::create([
            'name' => 'Sarah Dermawan',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password123'),
            'role' => 'donatur',
            'is_verified' => false, // Pending verification
            'email_verified_at' => now(),
        ]);
    }
}
```

### **AdminSeeder - Creating Admin with firstOrCreate**
```php
// database/seeders/AdminSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@berkahhbabe.com'],
            [
                'name' => 'Admin Berkah BaBe',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
```

### **Running Seeders**
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UserSeeder

# Create new seeder
php artisan make:seeder ExampleSeeder
```

---

## 🔐 **Login System**

### **LoginController - Authentication Logic**
```php
// app/Http/Controllers/Auth/LoginController.php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Process login request
     */
    public function store(Request $request)
    {
        // 1. Validate input
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Attempt authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect to role-specific dashboard
            $user = Auth::user();
            $dashboardRoute = $user->getDashboardRoute();
            
            return redirect()->intended(route($dashboardRoute));
        }

        // 3. If failed, return with error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Process logout
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
```

### **User Model - Role-Based Dashboard Routing**
```php
// app/Models/User.php
public function getDashboardRoute(): string
{
    return match($this->role) {
        'admin' => 'admin.dashboard',
        'donatur' => 'donatur.dashboard',
        'organisasi' => 'organisasi.dashboard',
        default => 'dashboard'
    };
}

// Role checking methods
public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isDonatur(): bool
{
    return $this->role === 'donatur';
}

public function isOrganisasi(): bool
{
    return $this->role === 'organisasi';
}
```

### **Middleware - Role-Based Access Control**
```php
// app/Http/Middleware/AdminMiddleware.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Access denied. Admin only.');
        }

        return $next($request);
    }
}
```

### **Route Protection**
```php
// routes/web.php
// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});

// Donatur Routes
Route::middleware(['auth', 'verified', 'donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    Route::get('/dashboard', [DonaturController::class, 'dashboard'])->name('dashboard');
    Route::post('/buat-donasi', [DonaturController::class, 'storeDonation'])->name('store-donasi');
});
```

---

## 🔄 **CRUD API Operations**

### **Create (Store) - Donation Creation**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Store a new donation (CREATE)
 */
public function storeDonation(Request $request)
{
    // Validation
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

### **Read (Index/Show) - Display Donations**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Show user's donations (READ - Index)
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

/**
 * Show detailed view of a donation (READ - Show)
 */
public function showDonation(Donation $donation)
{
    // Authorization check
    if ($donation->user_id !== auth()->id()) {
        abort(403);
    }

    $donation->load(['claimedByOrganization', 'claimedByOrganization.organizationDetail']);

    return view('donatur.donation-detail', compact('donation'));
}
```

### **Update - Status Management**
```php
// app/Http/Controllers/AdminController.php
/**
 * Update donation status (UPDATE)
 */
public function updateDonationStatus(Donation $donation, Request $request)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,available,claimed,completed,cancelled'
    ]);

    $donation->update(['status' => $validated['status']]);

    return back()->with('success', 'Status donasi berhasil diperbarui.');
}

// app/Http/Controllers/OrganisasiController.php
/**
 * Claim donation (UPDATE)
 */
public function claimDonation(Donation $donation)
{
    // Validation
    if ($donation->status !== 'available') {
        return back()->with('error', 'Donasi tidak tersedia untuk diklaim.');
    }

    // Update donation
    $donation->update([
        'status' => 'claimed',
        'claimed_by_organization_id' => auth()->id()
    ]);

    return back()->with('success', 'Donasi berhasil diklaim.');
}
```

### **Delete - Cancel Donation**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Cancel a donation (Soft DELETE)
 */
public function cancelDonation(Donation $donation)
{
    // Authorization check
    if ($donation->user_id !== auth()->id()) {
        abort(403);
    }

    // Business logic check
    if (!in_array($donation->status, ['pending', 'available'])) {
        return back()->with('error', 'Donasi tidak dapat dibatalkan pada status ini.');
    }

    // Update status to cancelled (soft delete)
    $donation->update(['status' => 'cancelled']);

    return back()->with('success', 'Donasi berhasil dibatalkan.');
}

// app/Http/Controllers/AdminController.php
/**
 * Delete user (Hard DELETE)
 */
public function deleteUser(User $user)
{
    if ($user->isAdmin()) {
        return back()->with('error', 'Tidak dapat menghapus akun admin.');
    }

    $user->delete(); // Hard delete

    return back()->with('success', 'Pengguna berhasil dihapus.');
}
```

### **Model Scopes for Query Filtering**
```php
// app/Models/Donation.php
/**
 * Scope to get donations by status
 */
public function scopeByStatus($query, $status)
{
    return $query->where('status', $status);
}

/**
 * Scope to get donations for a specific user
 */
public function scopeForUser($query, $userId)
{
    return $query->where('user_id', $userId);
}

/**
 * Scope to get completed donations (history)
 */
public function scopeCompleted($query)
{
    return $query->whereIn('status', ['completed', 'cancelled']);
}

/**
 * Scope to get active donations (not completed/cancelled)
 */
public function scopeActive($query)
{
    return $query->whereNotIn('status', ['completed', 'cancelled']);
}
```

### **Search & Filter Operations**
```php
// app/Http/Controllers/DonaturController.php
/**
 * Search organizations with filters
 */
public function cariBantuan(Request $request)
{
    $searchTerm = $request->get('search');
    $category = $request->get('category');

    $organizations = OrganizationDetail::with('user')
        ->withActiveUsers()
        ->search($searchTerm);

    // Filter by category in JSON array
    if ($category) {
        $organizations->whereJsonContains('needs_list', $category);
    }

    $organizations = $organizations->paginate(9);

    // Get unique categories for filter dropdown
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

## 🛠️ **API Usage Examples**

### **Command Line Usage**
```bash
# Create migration with model
php artisan make:model Donation -m

# Create controller with resource methods
php artisan make:controller DonationController --resource

# Create seeder
php artisan make:seeder DonationSeeder

# Run specific migration
php artisan migrate --path=/database/migrations/filename.php

# Create factory
php artisan make:factory DonationFactory
```

### **Testing API Endpoints**
```bash
# Test login endpoint
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{"email":"donatur@donasibarang.com","password":"password123"}'

# Test creating donation (with authentication)
curl -X POST http://localhost:8000/donatur/buat-donasi \
  -H "Authorization: Bearer {token}" \
  -F "title=Baju Bekas" \
  -F "category=Pakaian" \
  -F "pickup_preference=self_deliver"
```

---

## 🔧 **Development Workflow**

```bash
# 1. Create and run migrations
php artisan make:migration create_donations_table
php artisan migrate

# 2. Create and run seeders
php artisan make:seeder DonationSeeder
php artisan db:seed --class=DonationSeeder

# 3. Start development server
php artisan serve

# 4. Test the application
# Login: admin@donasibarang.com / password123
# Donatur: donatur@donasibarang.com / password123
# Organisasi: organisasi@donasibarang.com / password123
```

This documentation shows the core technical implementation of the Berkah BaBe donation management system, focusing on database structure, data seeding, authentication, and CRUD operations that power the application.