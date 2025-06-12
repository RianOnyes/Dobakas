<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_name',
        'contact_person',
        'contact_phone',
        'organization_address',
        'description',
        'needs_list',
        'document_url',
    ];

    protected $casts = [
        'needs_list' => 'array',
    ];

    /**
     * Get the user that owns the organization detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
} 