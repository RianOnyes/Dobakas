<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\OrganizationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganisasiController extends Controller
{
    /**
     * Show the organization dashboard.
     */
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

    /**
     * Show organization profile form.
     */
    public function profile()
    {
        $organizationDetail = auth()->user()->organizationDetail;
        
        return view('organisasi.profile', compact('organizationDetail'));
    }

    /**
     * Update organization profile.
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

    /**
     * Show claimed donations (Donasi Diklaim).
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
     * Show available donations in admin warehouse.
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

    /**
     * Show detailed view of a donation.
     */
    public function showDonation(Donation $donation)
    {
        // Make sure this is an available donation
        if ($donation->status !== 'available') {
            abort(404, 'Donasi tidak tersedia.');
        }

        $donation->load('user');

        return view('organisasi.donation-detail', compact('donation'));
    }

    /**
     * Claim a donation.
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

        $donation->update([
            'status' => 'claimed',
            'claimed_by_organization_id' => auth()->id()
        ]);

        return back()->with('success', 'Donasi berhasil diklaim. Silakan koordinasi dengan donatur untuk pengambilan.');
    }

    /**
     * Mark donation as completed.
     */
    public function completeDonation(Donation $donation)
    {
        // Make sure this donation is claimed by this organization
        if ($donation->claimed_by_organization_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke donasi ini.');
        }

        // Make sure donation is in claimed status
        if ($donation->status !== 'claimed') {
            return back()->with('error', 'Donasi hanya dapat diselesaikan dari status diklaim.');
        }

        $donation->update(['status' => 'completed']);

        return back()->with('success', 'Donasi telah ditandai sebagai selesai.');
    }

    /**
     * Show requests management page.
     */
    public function requests(Request $request)
    {
        $status = $request->get('status');
        
        $requests = auth()->user()->donationRequests()
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(9);

        return view('organisasi.requests', compact('requests', 'status'));
    }

    /**
     * Show create request form.
     */
    public function createRequest()
    {
        return view('organisasi.create-request');
    }

    /**
     * Store a new donation request.
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

    /**
     * Show detailed view of a donation request.
     */
    public function showRequest(DonationRequest $request)
    {
        // Make sure this request belongs to the authenticated organization
        if ($request->organization_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke permintaan ini.');
        }

        return view('organisasi.request-detail', compact('request'));
    }

    /**
     * Update donation request status.
     */
    public function updateRequestStatus(DonationRequest $request, Request $httpRequest)
    {
        // Make sure this request belongs to the authenticated organization
        if ($request->organization_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke permintaan ini.');
        }

        $validated = $httpRequest->validate([
            'status' => 'required|in:active,fulfilled,cancelled'
        ]);

        $request->update(['status' => $validated['status']]);

        $statusLabel = match($validated['status']) {
            'fulfilled' => 'terpenuhi',
            'cancelled' => 'dibatalkan',
            'active' => 'diaktifkan kembali',
            default => 'diperbarui'
        };

        return back()->with('success', "Permintaan berhasil {$statusLabel}.");
    }

    /**
     * Delete donation request.
     */
    public function deleteRequest(DonationRequest $request)
    {
        // Make sure this request belongs to the authenticated organization
        if ($request->organization_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke permintaan ini.');
        }

        $request->delete();

        return back()->with('success', 'Permintaan berhasil dihapus.');
    }
} 