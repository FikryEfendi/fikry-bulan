<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('judul_undangan')->nullable();
            $table->text('pengantar')->nullable();
            $table->string('dress_code')->nullable();
            $table->text('maps_link')->nullable();
            $table->text('maps_embed')->nullable();
            $table->string('foto_cover')->nullable();
            $table->string('foto_penutup')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
