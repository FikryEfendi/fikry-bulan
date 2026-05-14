<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mempelai extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe',
        'nama_lengkap',
        'nama_panggilan',
        'nama_ayah',
        'nama_ibu',
        'status_keluarga',
        'foto',
    ];
}
