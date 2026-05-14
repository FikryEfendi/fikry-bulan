<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        return response()->json(Galeri::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image',
        ]);

        $path = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'path_foto' => 'storage/' . $path,
            'caption'   => $request->input('caption'),
        ]);

        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $galeri = Galeri::find($request->id);
        if ($galeri) {
            // Remove storage/ prefix if present
            $path = str_replace('storage/', '', $galeri->path_foto);
            Storage::disk('public')->delete($path);
            $galeri->delete();
        }
        return response()->json(['status' => 'success']);
    }
}
