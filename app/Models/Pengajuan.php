<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'nomor_pengajuan',
        'user_id',
        'judul',
        'deskripsi',
        'keperluan',
        'total_harga',
        'status',
        'approved_by',
        'catatan_approval',
        'tanggal_pengajuan',
        'tanggal_approval',
        'revision_by',
        'tanggal_revision'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_approval' => 'datetime',
        'tanggal_revision' => 'datetime',
        'total_harga' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function reviser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revision_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PengajuanItem::class);
    }

    // Helper methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function needsRevision(): bool
    {
        return $this->status === 'revision';
    }

    public function revisionHistory()
    {
        return $this->hasMany(RevisionHistory::class);
    }

    public function latestRevision()
    {
        return $this->hasOne(RevisionHistory::class)->latest('tanggal_revision');
    }
}
