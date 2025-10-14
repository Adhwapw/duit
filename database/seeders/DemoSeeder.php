<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dompet;
use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email'=>'demo@contoh.test'],
            ['name'=>'Demo', 'password'=>Hash::make('password')]
        );

        $dompet = Dompet::create([
            'user_id'=>$user->id,
            'nama_dompet'=>'Dompet Tunai',
            'jenis_dompet'=>'tunai',
            'saldo_awal'=>500000,
            'keterangan'=>null,
        ]);

        $katGaji = Kategori::create([
            'user_id'=>$user->id,
            'nama_kategori'=>'Gaji',
            'tipe'=>'pemasukan',
            'warna_opsional'=>null,
        ]);

        $katMakan = Kategori::create([
            'user_id'=>$user->id,
            'nama_kategori'=>'Makanan',
            'tipe'=>'pengeluaran',
            'warna_opsional'=>null,
        ]);

        Transaksi::create([
            'user_id'=>$user->id,
            'dompet_id'=>$dompet->id,
            'kategori_id'=>$katGaji->id,
            'tanggal'=>now()->toDateString(),
            'jenis'=>'pemasukan',
            'jumlah'=>3000000,
            'catatan'=>'Gaji Bulanan',
        ]);

        Transaksi::create([
            'user_id'=>$user->id,
            'dompet_id'=>$dompet->id,
            'kategori_id'=>$katMakan->id,
            'tanggal'=>now()->toDateString(),
            'jenis'=>'pengeluaran',
            'jumlah'=>50000,
            'catatan'=>'Sarapan',
        ]);

        Transaksi::create([
            'user_id'=>$user->id,
            'dompet_id'=>$dompet->id,
            'kategori_id'=>$katMakan->id,
            'tanggal'=>now()->subDay()->toDateString(),
            'jenis'=>'pengeluaran',
            'jumlah'=>75000,
            'catatan'=>'Makan siang',
        ]);
    }
}
