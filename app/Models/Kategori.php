<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori';
    public $timestamps = true;
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = ['user_id','nama_kategori','tipe','warna_opsional'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function transaksi(): HasMany { return $this->hasMany(Transaksi::class); }
}

