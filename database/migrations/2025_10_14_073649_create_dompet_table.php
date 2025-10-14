<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dompet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_dompet');
            $table->enum('jenis_dompet', ['tunai', 'bank', 'e-wallet']);
            $table->decimal('saldo_awal', 14, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }
    public function down(): void {
        Schema::dropIfExists('dompet');
    }
};
