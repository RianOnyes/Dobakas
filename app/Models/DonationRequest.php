<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DonationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'category',
        'urgency_level',
        'quantity_needed',
        'location',
        'status',
        'needed_by',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'needed_by' => 'date',
    ];

    /**
     * Get the organization that owns the request.
     */
    public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

    /**
     * Scope to get active requests.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get requests by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get requests for a specific organization.
     */
    public function scopeForOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'fulfilled' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabel()
    {
        return match($this->status) {
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
        return match($this->urgency_level) {
            'low' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'high' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
        };
    }

    /**
     * Get urgency level label.
     */
    public function getUrgencyLabel()
    {
        return match($this->urgency_level) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            default => 'Unknown'
        };
    }

    /**
     * Check if request is urgent (deadline within 7 days).
     */
    public function isUrgent()
    {
        if (!$this->needed_by) {
            return $this->urgency_level === 'high';
        }
        
        return $this->needed_by <= Carbon::now()->addDays(7);
    }

    /**
     * Get formatted needed by date.
     */
    public function getFormattedNeededBy()
    {
        if (!$this->needed_by) {
            return null;
        }
        
        return $this->needed_by->format('d M Y');
    }
}
