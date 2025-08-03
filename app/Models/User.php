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
        'user_role_id',
        'nip',
        'jabatan',
        'unit_kerja',
        'is_active'
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
        ];
    }

    // Relations
    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function approvedPengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'approved_by');
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->userRole?->name === 'admin';
    }

    public function isPengaju(): bool
    {
        return $this->userRole?->name === 'pengaju';
    }

    public function isApprover(): bool
    {
        return $this->userRole?->name === 'approver';
    }
}
