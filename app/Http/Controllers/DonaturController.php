<?php

namespace App\Http\Controllers;

use App\Models\OrganizationDetail;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonaturController extends Controller
{
    /**
     * Show the donatur dashboard.
     */
    public function dashboard()
    {
        return view('donatur.dashboard');
    }

    /**
     * Show the search page for organizations needing help.
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

    /**
     * Show detailed view of an organization.
     */
    public function showOrganization(OrganizationDetail $organization)
    {
        // Make sure the organization belongs to an active user
        if (!$organization->user || $organization->user->role !== 'organisasi' || !$organization->user->email_verified_at) {
            abort(404);
        }

        return view('donatur.organization-detail', compact('organization'));
    }

    /**
     * Show the create donation form.
     */
    public function createDonation()
    {
        return view('donatur.create-donation');
    }

    /**
     * Store a new donation.
     */
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

        // Handle photo uploads
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
            'status' => 'pending'
        ]);

        return redirect()->route('donatur.donasi-saya')->with('success', 'Donasi berhasil dibuat dan sedang menunggu verifikasi admin.');
    }

    /**
     * Show user's donations (Donasi Saya).
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
     * Show user's donation history (Riwayat).
     */
    public function riwayat(Request $request)
    {
        $donations = Donation::with(['claimedByOrganization', 'claimedByOrganization.organizationDetail'])
            ->forUser(auth()->id())
            ->completed()
            ->latest()
            ->paginate(9);

        return view('donatur.riwayat', compact('donations'));
    }

    /**
     * Show detailed view of a donation.
     */
    public function showDonation(Donation $donation)
    {
        // Make sure this donation belongs to the authenticated user
        if ($donation->user_id !== auth()->id()) {
            abort(403);
        }

        $donation->load(['claimedByOrganization', 'claimedByOrganization.organizationDetail']);

        return view('donatur.donation-detail', compact('donation'));
    }

    /**
     * Cancel a donation.
     */
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
} 