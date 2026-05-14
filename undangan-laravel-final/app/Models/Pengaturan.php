<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_undangan',
        'pengantar',
        'dress_code',
        'maps_link',
        'maps_embed',
        'foto_cover',
        'foto_penutup',
        'tanggal_acara',
        'nama_venue',
        'alamat_venue'
    ];
}
