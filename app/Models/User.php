<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_verified',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
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

    public function getDashboardRoute(): string
    {
        return match($this->role) {
            'admin' => 'admin.dashboard',
            'donatur' => 'donatur.dashboard',
            'organisasi' => 'organisasi.dashboard',
            default => 'dashboard'
        };
    }

    /**
     * Get the organization detail associated with the user.
     */
    public function organizationDetail()
    {
        return $this->hasOne(OrganizationDetail::class);
    }

    /**
     * Get the donations made by this user (if donatur).
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the donations claimed by this user (if organisasi).
     */
    public function claimedDonations()
    {
        return $this->hasMany(Donation::class, 'claimed_by_organization_id');
    }

    /**
     * Get the donation requests made by this user (if organisasi).
     */
    public function donationRequests()
    {
        return $this->hasMany(DonationRequest::class, 'organization_id');
    }
}
