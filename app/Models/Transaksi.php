<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    public $timestamps = true;
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'user_id','dompet_id','kategori_id','tanggal','jenis','jumlah','catatan'
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function dompet(): BelongsTo { return $this->belongsTo(Dompet::class); }
    public function kategori(): BelongsTo { return $this->belongsTo(Kategori::class); }
}

