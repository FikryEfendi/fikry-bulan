<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rsvp', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tamu');
            $table->text('pesan')->nullable();
            $table->enum('konfirmasi_hadir', ['Hadir', 'Tidak Hadir', 'Belum'])->default('Belum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rsvp');
    }
};