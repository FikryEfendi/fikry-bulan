<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara;

class AcaraController extends Controller
{
    public function index()
    {
        return response()->json(Acara::orderBy('jam_mulai')->get());
    }

    public function store(Request $request)
    {
        Acara::create($request->all());
        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        $acara = Acara::find($request->id);
        if ($acara) {
            $acara->update($request->all());
        }
        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $acara = Acara::find($request->id);
        if ($acara) {
            $acara->delete();
        }
        return response()->json(['status' => 'success']);
    }
}
