<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donation;
use App\Models\OrganizationDetail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Carbon\Carbon;

class AdminController extends Controller
{
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

    public function users(): View
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function verifyUser(User $user)
    {
        $user->update(['is_verified' => true]);
        return back()->with('success', 'User verified successfully');
    }

    /**
     * Show combined statistics and reports page with filtering.
     */
    public function statistics(Request $request): View
    {
        // Get filter parameters
        $period = $request->get('period', 'all'); // all, today, week, month, year, custom
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Apply date filtering
        $query = $this->applyDateFilter($period, $startDate, $endDate);

        // Monthly donation trends (based on selected period)
        $monthlyDonations = $this->getMonthlyDonations($query['donations']);

        // Monthly user trends
        $monthlyUsers = $this->getMonthlyUsers($query['users']);

        // Donation status distribution
        $statusCounts = $query['donations']
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
        
        // Ensure all status keys exist with default values
        $donationsByStatus = collect([
            'pending' => 0,
            'available' => 0,
            'claimed' => 0,
            'completed' => 0,
            'cancelled' => 0
        ])->merge($statusCounts);

        // For user distribution chart, we always want to show total counts regardless of date filter
        // Only apply date filter for "new users this period"
        $totalUsers = User::count();
        $totalDonatur = User::where('role', 'donatur')->count();
        $totalOrganisasi = User::where('role', 'organisasi')->count();

        // Basic statistics with filtering
        $stats = [
            // User statistics (total counts always, period-specific for new users)
            'total_users' => $totalUsers,
            'total_donatur' => $totalDonatur,
            'total_organisasi' => $totalOrganisasi,
            'new_users_this_period' => $query['users']->count(),
            
            // Donation statistics
            'total_donations' => $query['donations']->count(),
            'pending_donations' => $donationsByStatus['pending'],
            'available_donations' => $donationsByStatus['available'],
            'completed_donations' => $donationsByStatus['completed'],
            'cancelled_donations' => $donationsByStatus['cancelled'],
            
            // Organization statistics
            'total_organizations' => $query['organizations']->count(),
            'verified_organizations' => $query['organizations']->whereHas('user', function($q) {
                $q->whereNotNull('email_verified_at');
            })->count(),
        ];

        // Top categories
        $topCategories = $query['donations']
            ->selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Top organizations
        $topOrganizations = DB::table('donations')
            ->join('users', 'donations.claimed_by_organization_id', '=', 'users.id')
            ->join('organization_details', 'users.id', '=', 'organization_details.user_id')
            ->select('organization_details.organization_name', DB::raw('COUNT(*) as donations_count'))
            ->where('donations.status', 'completed')
            ->whereNotNull('donations.claimed_by_organization_id')
            ->whereNotNull('organization_details.organization_name')
            ->when($period !== 'all', function($q) use ($query) {
                // Apply same date filtering to joined table
                $dates = $this->getDateRange($period ?? 'all', request('start_date'), request('end_date'));
                if ($dates['start'] && $dates['end']) {
                    $q->whereBetween('donations.created_at', [$dates['start'], $dates['end']]);
                }
            })
            ->groupBy('organization_details.organization_name')
            ->orderByDesc('donations_count')
            ->limit(10)
            ->get();

        // Recent activities - combine different types of activities
        $recentActivities = collect();
        
        try {

        // Recent donations (new donations submitted)
        $newDonations = $query['donations']
            ->with('user')
            ->whereHas('user')
            ->whereNotNull('created_at')
            ->latest()
            ->limit(5)
            ->get()
            ->filter(function($donation) {
                return $donation->user && $donation->user->name;
            })
            ->map(function($donation) {
                return [
                    'type' => 'donation_created',
                    'message' => "{$donation->user->name} mengirim donasi baru",
                    'details' => $donation->title,
                    'user_name' => $donation->user->name,
                    'user_role' => $donation->user->role,
                    'created_at' => $donation->created_at,
                    'status' => $donation->status,
                    'icon' => 'gift'
                ];
            });

        // Recent donation status changes (claimed donations)
        $claimedDonations = $query['donations']
            ->with(['user', 'claimedByOrganization'])
            ->whereHas('user')
            ->whereHas('claimedByOrganization')
            ->where('status', 'claimed')
            ->whereNotNull('created_at')
            ->latest('updated_at')
            ->limit(3)
            ->get()
            ->filter(function($donation) {
                return $donation->user && $donation->user->name && 
                       $donation->claimedByOrganization && $donation->claimedByOrganization->name;
            })
            ->map(function($donation) {
                return [
                    'type' => 'donation_claimed',
                    'message' => "{$donation->claimedByOrganization->name} mengklaim donasi",
                    'details' => $donation->title,
                    'user_name' => $donation->claimedByOrganization->name,
                    'user_role' => $donation->claimedByOrganization->role,
                    'created_at' => $donation->updated_at,
                    'status' => $donation->status,
                    'icon' => 'hand'
                ];
            });

        // Recent user registrations
        $newUsers = $query['users']
            ->whereNotNull('created_at')
            ->whereNotNull('name')
            ->latest()
            ->limit(3)
            ->get()
            ->filter(function($user) {
                return $user->name && $user->role;
            })
            ->map(function($user) {
                $roleLabel = $user->role === 'donatur' ? 'Donatur' : 'Organisasi';
                return [
                    'type' => 'user_registered',
                    'message' => "{$user->name} bergabung sebagai {$roleLabel}",
                    'details' => "Pengguna baru terdaftar",
                    'user_name' => $user->name,
                    'user_role' => $user->role,
                    'created_at' => $user->created_at,
                    'status' => $user->is_verified ? 'verified' : 'unverified',
                    'icon' => 'user-plus'
                ];
            });

        // Recent completed donations
        $completedDonations = $query['donations']
            ->with(['user', 'claimedByOrganization'])
            ->whereHas('user')
            ->where('status', 'completed')
            ->whereNotNull('created_at')
            ->latest('updated_at')
            ->limit(2)
            ->get()
            ->filter(function($donation) {
                return $donation->user && $donation->title;
            })
            ->map(function($donation) {
                $organizationName = 'Organisasi';
                if ($donation->claimedByOrganization && $donation->claimedByOrganization->name) {
                    $organizationName = $donation->claimedByOrganization->name;
                }
                
                return [
                    'type' => 'donation_completed',
                    'message' => "Donasi diselesaikan",
                    'details' => $donation->title,
                    'user_name' => $organizationName,
                    'user_role' => 'organisasi',
                    'created_at' => $donation->updated_at,
                    'status' => $donation->status,
                    'icon' => 'check-circle'
                ];
            });

        // Merge and sort all activities by date
        $recentActivities = $newDonations
            ->concat($claimedDonations)
            ->concat($newUsers)
            ->concat($completedDonations)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();
            
        } catch (\Exception $e) {
            // If there's an error getting activities, return empty collection
            $recentActivities = collect();
        }

        // Category statistics
        $categoryStats = $query['donations']
            ->selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('count')
            ->get();

        return view('admin.statistics', compact(
            'stats', 
            'monthlyDonations', 
            'monthlyUsers',
            'donationsByStatus',
            'topCategories', 
            'topOrganizations',
            'recentActivities',
            'categoryStats',
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

        // Apply date filtering
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
            fputcsv($file, ['Donasi Pending', $query['donations']->where('status', 'pending')->count()]);
            fputcsv($file, ['Donasi Available', $query['donations']->where('status', 'available')->count()]);
            fputcsv($file, ['Donasi Completed', $query['donations']->where('status', 'completed')->count()]);
            fputcsv($file, ['Donasi Cancelled', $query['donations']->where('status', 'cancelled')->count()]);
            fputcsv($file, []);

            // Donations detail
            fputcsv($file, ['DETAIL DONASI']);
            fputcsv($file, ['Judul', 'Kategori', 'Donatur', 'Status', 'Tanggal Dibuat']);
            
            $query['donations']->with('user')->whereHas('user')->whereNotNull('created_at')->chunk(100, function($donations) use ($file) {
                foreach ($donations as $donation) {
                    fputcsv($file, [
                        $donation->title,
                        $donation->category ?? 'Tidak ada kategori',
                        $donation->user->name,
                        ucfirst($donation->status),
                        $donation->created_at->format('d/m/Y H:i:s')
                    ]);
                }
            });

            fputcsv($file, []);

            // Category statistics
            fputcsv($file, ['STATISTIK KATEGORI']);
            fputcsv($file, ['Kategori', 'Jumlah Donasi']);
            
            $categoryStats = $query['donations']
                ->selectRaw('category, COUNT(*) as count')
                ->whereNotNull('category')
                ->groupBy('category')
                ->orderByDesc('count')
                ->get();

            foreach ($categoryStats as $category) {
                fputcsv($file, [$category->category, $category->count]);
            }

            fputcsv($file, []);

            // Users detail
            fputcsv($file, ['DETAIL PENGGUNA']);
            fputcsv($file, ['Nama', 'Email', 'Role', 'Verified', 'Tanggal Daftar']);
            
            $query['users']->chunk(100, function($users) use ($file) {
                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->name,
                        $user->email,
                        ucfirst($user->role),
                        $user->email_verified_at ? 'Ya' : 'Tidak',
                        $user->created_at->format('d/m/Y H:i:s')
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Apply date filtering to queries
     */
    private function applyDateFilter($period, $startDate = null, $endDate = null)
    {
        $dates = $this->getDateRange($period, $startDate, $endDate);

        $userQuery = User::query();
        $donationQuery = Donation::query();
        $orgQuery = OrganizationDetail::query();

        if ($dates['start'] && $dates['end']) {
            $userQuery->whereBetween('created_at', [$dates['start'], $dates['end']]);
            $donationQuery->whereBetween('created_at', [$dates['start'], $dates['end']]);
            $orgQuery->whereBetween('created_at', [$dates['start'], $dates['end']]);
        }

        return [
            'users' => $userQuery,
            'donations' => $donationQuery,
            'organizations' => $orgQuery
        ];
    }

    /**
     * Get date range based on period
     */
    private function getDateRange($period, $startDate = null, $endDate = null)
    {
        switch ($period) {
            case 'today':
                return [
                    'start' => Carbon::today(),
                    'end' => Carbon::today()->endOfDay()
                ];
            case 'week':
                return [
                    'start' => Carbon::now()->startOfWeek(),
                    'end' => Carbon::now()->endOfWeek()
                ];
            case 'month':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth()
                ];
            case 'year':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now()->endOfYear()
                ];
            case 'custom':
                return [
                    'start' => $startDate ? Carbon::parse($startDate)->startOfDay() : null,
                    'end' => $endDate ? Carbon::parse($endDate)->endOfDay() : null
                ];
            default:
                return ['start' => null, 'end' => null];
        }
    }

    /**
     * Get monthly donations data
     */
    private function getMonthlyDonations($donationQuery)
    {
        return $donationQuery
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
    }

    /**
     * Get monthly users data
     */
    private function getMonthlyUsers($userQuery)
    {
        return $userQuery
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at), YEAR(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();
    }

    /**
     * Get period label for display
     */
    private function getPeriodLabel($period, $startDate = null, $endDate = null)
    {
        switch ($period) {
            case 'today':
                return 'Hari Ini';
            case 'week':
                return 'Minggu Ini';
            case 'month':
                return 'Bulan Ini';
            case 'year':
                return 'Tahun Ini';
            case 'custom':
                $start = $startDate ? Carbon::parse($startDate)->format('d/m/Y') : '-';
                $end = $endDate ? Carbon::parse($endDate)->format('d/m/Y') : '-';
                return "Custom ({$start} - {$end})";
            default:
                return 'Semua Data';
        }
    }

    /**
     * Show donations management page.
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
     * Update donation status.
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
     * Show organizations management page.
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
     * Show organization detail.
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

    /**
     * Show settings page.
     */
    public function settings(): View
    {
        return view('admin.settings');
    }

    /**
     * Update system settings.
     */
    public function updateSettings(Request $request)
    {
        // This would typically update system settings stored in a settings table
        // For now, we'll just return success
        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Show donation detail.
     */
    public function showDonation(Donation $donation): View
    {
        $donation->load(['user', 'claimedByOrganization.organizationDetail']);
        return view('admin.donation-detail', compact('donation'));
    }
} 