<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UndanganController extends Controller
{
    public function index(Request $request)
    {
        $pengaturan = \App\Models\Pengaturan::first();
        $mempelaiPria = \App\Models\Mempelai::where('tipe', 'pria')->first();
        $mempelaiWanita = \App\Models\Mempelai::where('tipe', 'wanita')->first();
        $akad = \App\Models\Acara::where('nama_acara', 'Akad Nikah')->first();
        $resepsi = \App\Models\Acara::where('nama_acara', 'Resepsi')->first();
        
        $nama_pria = $mempelaiPria ? $mempelaiPria->nama_lengkap : '';
        $nama_wanita = $mempelaiWanita ? $mempelaiWanita->nama_lengkap : '';

        $nama_depan_pria   = $nama_pria ? explode(' ', $nama_pria)[0] : '';
        if ($mempelaiPria && count(explode(' ', $nama_pria)) > 1) {
            $nama_depan_pria = explode(' ', $nama_pria)[1]; // or you can use nama_panggilan from DB
        }
        $nama_depan_wanita = $nama_wanita ? explode(' ', $nama_wanita)[0] : '';
        
        if ($mempelaiPria && $mempelaiPria->nama_panggilan) {
            $nama_depan_pria = $mempelaiPria->nama_panggilan;
        }
        if ($mempelaiWanita && $mempelaiWanita->nama_panggilan) {
            $nama_depan_wanita = $mempelaiWanita->nama_panggilan;
        }

        $tanggal_acara_formatted = '';
        $tanggal_numerik = '';
        if ($pengaturan && $pengaturan->tanggal_acara) {
            $carbonDate = \Carbon\Carbon::parse($pengaturan->tanggal_acara);
            $carbonDate->locale('id');
            $tanggal_acara_formatted = $carbonDate->translatedFormat('l, d F Y');
            $tanggal_numerik = $carbonDate->format('d.m.y');
        }

        return view('undangan.index', [
            'page_title'        => ($pengaturan ? $pengaturan->judul_undangan : 'Undangan Pernikahan') . ' — ' . $nama_depan_pria . ' & ' . $nama_depan_wanita,
            'hari_h'            => $pengaturan && $pengaturan->tanggal_acara ? \Carbon\Carbon::parse($pengaturan->tanggal_acara)->format('Y-m-d\TH:i:s') : '2027-02-14T08:00:00',
            'pengaturan'        => $pengaturan,
            'mempelai_pria'     => $mempelaiPria,
            'mempelai_wanita'   => $mempelaiWanita,
            'semua_acara'       => \App\Models\Acara::orderBy('jam_mulai')->get(),
            'nama_pria'         => $nama_pria,
            'nama_wanita'       => $nama_wanita,
            'nama_depan_pria'   => $nama_depan_pria,
            'nama_depan_wanita' => $nama_depan_wanita,
            'ortu_pria'         => $mempelaiPria ? 'Bapak ' . $mempelaiPria->nama_ayah . ' & Ibu ' . $mempelaiPria->nama_ibu : '',
            'ortu_wanita'       => $mempelaiWanita ? 'Bapak ' . $mempelaiWanita->nama_ayah . ' & Ibu ' . $mempelaiWanita->nama_ibu : '',
            'tanggal_acara'     => $tanggal_acara_formatted,
            'tanggal_numerik'   => $tanggal_numerik,
            'dress_code'        => $pengaturan ? $pengaturan->dress_code : '',
            'nama_venue'        => $pengaturan ? $pengaturan->nama_venue : '',
            'alamat_venue'      => $pengaturan ? $pengaturan->alamat_venue : '',
            'maps_embed'        => $pengaturan ? $pengaturan->maps_embed : '',
            'maps_link'         => $pengaturan ? $pengaturan->maps_link : '',
            'nama_tamu'         => $request->query('tamu', 'Tamu Undangan'),
            'love_story'        => \App\Models\Cerita::orderBy('tahun', 'asc')->get(),
            'galeri'            => \App\Models\Galeri::all(),
        ]);
    }
}