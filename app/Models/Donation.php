<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'photos',
        'status',
        'pickup_preference',
        'location',
        'claimed_by_organization_id',
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    /**
     * Get the user (donatur) that owns the donation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organization that claimed this donation.
     */
    public function claimedByOrganization()
    {
        return $this->belongsTo(User::class, 'claimed_by_organization_id');
    }

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
     * Scope to get completed donations (riwayat)
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

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'available' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'claimed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
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

    /**
     * Get pickup preference label
     */
    public function getPickupPreferenceLabelAttribute()
    {
        return match($this->pickup_preference) {
            'self_deliver' => 'Antar Sendiri',
            'needs_pickup' => 'Perlu Dijemput',
            default => 'Unknown'
        };
    }

    /**
     * Get status badge class (method)
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'available' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'claimed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
        };
    }

    /**
     * Get status label (method)
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
} 