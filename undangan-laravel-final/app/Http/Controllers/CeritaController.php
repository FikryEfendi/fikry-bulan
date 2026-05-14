<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cerita;

class CeritaController extends Controller
{
    public function index()
    {
        return response()->json(Cerita::orderBy('tahun', 'asc')->get());
    }

    public function store(Request $request)
    {
        Cerita::create($request->all());
        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        $cerita = Cerita::find($request->id);
        if ($cerita) {
            $cerita->update($request->all());
        }
        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $cerita = Cerita::find($request->id);
        if ($cerita) {
            $cerita->delete();
        }
        return response()->json(['status' => 'success']);
    }
}
