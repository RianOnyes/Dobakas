<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
} 