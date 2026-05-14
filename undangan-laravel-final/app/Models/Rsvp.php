<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $table = 'rsvp';
    public $timestamps = false;

    protected $fillable = [
        'nama_tamu',
        'pesan',
        'konfirmasi_hadir',
    ];
}