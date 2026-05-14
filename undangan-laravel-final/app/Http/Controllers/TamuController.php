<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    public function get()
    {
        $data = Rsvp::orderBy('id', 'desc')->get()->map(function ($row) {
            $status = 'belum';
            if ($row->konfirmasi_hadir === 'Hadir') {
                $status = 'hadir';
            } elseif ($row->konfirmasi_hadir === 'Tidak Hadir') {
                $status = 'tidak';
            }

            return [
                'id'     => $row->id,
                'nama'   => $row->nama_tamu,
                'pesan'  => $row->pesan,
                'status' => $status,
                'waktu'  => $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-',
            ];
        });

        return response()->json($data);
    }

    public function add(Request $request)
    {
        $nama            = trim($request->input('nama', ''));
        $pesan           = trim($request->input('pesan', ''));
        $konfirmasi_raw  = trim($request->input('konfirmasi_hadir', ''));

        if (empty($nama))  return response()->json(['status' => 'error', 'message' => 'Nama tidak boleh kosong']);
        if (empty($pesan)) return response()->json(['status' => 'error', 'message' => 'Pesan tidak boleh kosong']);
        
        if (!in_array($konfirmasi_raw, ['Hadir', 'Tidak Hadir'])) {
            return response()->json(['status' => 'error', 'message' => 'Konfirmasi tidak valid']);
        }

        $existing = Rsvp::where('nama_tamu', $nama)->first();
        if ($existing) {
            $existing->update(['pesan' => $pesan, 'konfirmasi_hadir' => $konfirmasi_raw]);
        } else {
            Rsvp::create(['nama_tamu' => $nama, 'pesan' => $pesan, 'konfirmasi_hadir' => $konfirmasi_raw]);
        }

        return response()->json(['status' => 'success']);
    }

    public function addAdmin(Request $request)
    {
        $nama = trim($request->input('nama', ''));
        
        if (empty($nama)) {
            return response()->json(['status' => 'error', 'message' => 'Nama tidak boleh kosong'], 400);
        }

        Rsvp::create([
            'nama_tamu' => $nama, 
            'pesan' => '', 
            'konfirmasi_hadir' => null
        ]);

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        $id     = (int) $request->input('id', 0);
        $nama   = trim($request->input('nama', ''));
        $status_raw = $request->input('status');

        $status = null;
        if ($status_raw === 'hadir') {
            $status = 'Hadir';
        } elseif ($status_raw === 'tidak') {
            $status = 'Tidak Hadir';
        }

        if ($id <= 0 || empty($nama)) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        Rsvp::where('id', $id)->update([
            'nama_tamu' => $nama, 
            'konfirmasi_hadir' => $status
        ]);
        
        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $id = (int) $request->input('id', 0);
        if ($id <= 0) return response()->json(['status' => 'error', 'message' => 'ID tidak valid']);

        Rsvp::destroy($id);
        return response()->json(['status' => 'success']);
    }
}