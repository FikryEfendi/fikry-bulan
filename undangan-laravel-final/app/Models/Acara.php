<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_acara',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'nama_venue',
        'alamat_venue',
    ];
}
