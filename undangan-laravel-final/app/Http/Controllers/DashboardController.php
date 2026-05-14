<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pengaturan = \App\Models\Pengaturan::first();
        $mempelaiPria = \App\Models\Mempelai::where('tipe', 'pria')->first();
        $mempelaiWanita = \App\Models\Mempelai::where('tipe', 'wanita')->first();
        $akad = \App\Models\Acara::where('nama_acara', 'Akad Nikah')->first();
        $resepsi = \App\Models\Acara::where('nama_acara', 'Resepsi')->first();

        $nama_pria = $mempelaiPria ? $mempelaiPria->nama_lengkap : '';
        $nama_wanita = $mempelaiWanita ? $mempelaiWanita->nama_lengkap : '';

        $tanggal_acara = $akad ? $akad->tanggal : date('Y-m-d');
        $hari_h = new \DateTime($tanggal_acara . ' ' . ($akad ? $akad->jam_mulai : '00:00:00'));
        $sekarang = new \DateTime();

        $selisih = $sekarang->diff($hari_h);
        $sisa_hari = ($selisih->invert === 0) ? $selisih->days : 0;

        return view('dashboard.index', [
            'page_title'  => 'Dashboard — ' . ($pengaturan ? $pengaturan->judul_undangan : 'Undangan'),
            'pengaturan'  => $pengaturan,
            'mempelaiPria' => $mempelaiPria,
            'mempelaiWanita' => $mempelaiWanita,
            'akad'        => $akad,
            'resepsi'     => $resepsi,
            'cerita'      => \App\Models\Cerita::orderBy('tahun', 'asc')->get(),
            'galeri'      => \App\Models\Galeri::all(),
            'sisa_hari'   => $sisa_hari,
            'hari_h'      => $hari_h,
            'tanggal'     => $tanggal_acara,
            'nama_venue'  => $akad ? $akad->nama_venue : '',
            'jam_akad'    => $akad ? $akad->jam_mulai : '',
            'jam_resepsi' => $resepsi ? $resepsi->jam_mulai . ($resepsi->jam_selesai && $resepsi->jam_selesai !== 'Selesai' ? ' - ' . $resepsi->jam_selesai : '') : '',
            'dress_code'  => $pengaturan ? $pengaturan->dress_code : '',
        ]);
    }

    public function update(\Illuminate\Http\Request $request)
    {
        // Update Mempelai Pria
        $priaData = [
            'nama_lengkap'   => $request->input('namaPria'),
            'nama_panggilan' => $request->input('panggilanPria'),
            'status_keluarga'=> $request->input('statusPria'),
            'nama_ayah'      => $request->input('ayahPria'),
            'nama_ibu'       => $request->input('ibuPria'),
        ];
        if ($request->hasFile('fotoPria')) {
            $priaData['foto'] = $request->file('fotoPria')->store('mempelai', 'public');
        }
        \App\Models\Mempelai::where('tipe', 'pria')->update($priaData);

        // Update Mempelai Wanita
        $wanitaData = [
            'nama_lengkap'   => $request->input('namaWanita'),
            'nama_panggilan' => $request->input('panggilanWanita'),
            'status_keluarga'=> $request->input('statusWanita'),
            'nama_ayah'      => $request->input('ayahWanita'),
            'nama_ibu'       => $request->input('ibuWanita'),
        ];
        if ($request->hasFile('fotoWanita')) {
            $wanitaData['foto'] = $request->file('fotoWanita')->store('mempelai', 'public');
        }
        \App\Models\Mempelai::where('tipe', 'wanita')->update($wanitaData);

        $pengaturanData = [
            'judul_undangan' => $request->input('judulUndangan'),
            'pengantar'      => $request->input('pengantar'),
            'dress_code'     => $request->input('dresscode'),
            'maps_link'      => $request->input('mapsLink'),
            'maps_embed'     => $request->input('mapsEmbed'),
            'tanggal_acara'  => $request->input('tanggalAcara'),
            'nama_venue'     => $request->input('namaVenue'),
            'alamat_venue'   => $request->input('alamatVenue'),
        ];

        if ($request->hasFile('fotoCover')) {
            $pengaturanData['foto_cover'] = $request->file('fotoCover')->store('cover', 'public');
        }
        if ($request->hasFile('fotoPenutup')) {
            $pengaturanData['foto_penutup'] = $request->file('fotoPenutup')->store('penutup', 'public');
        }

        $pengaturan = \App\Models\Pengaturan::first();
        if ($pengaturan) {
            $pengaturan->update($pengaturanData);
        } else {
            \App\Models\Pengaturan::create($pengaturanData);
        }

        return response()->json(['status' => 'success']);
    }
}