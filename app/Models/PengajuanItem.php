<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanItem extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'nama_barang',
        'deskripsi_barang',
        'jumlah',
        'satuan',
        'harga_satuan',
        'harga_total'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'harga_total' => 'decimal:2'
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
