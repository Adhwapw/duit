<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dompet extends Model
{
    protected $table = 'dompet';
    public $timestamps = true;
    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = ['user_id','nama_dompet','jenis_dompet','saldo_awal','keterangan'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function transaksi(): HasMany { return $this->hasMany(Transaksi::class); }
}

