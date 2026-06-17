<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriTemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriTemuanController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => KategoriTemuan::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_temuan' => 'required|string|max:255',
            'jenis_temuan' => 'required|in:Positif,Negatif',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $temuan = KategoriTemuan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kategori temuan berhasil ditambahkan',
            'data' => $temuan
        ]);
    }

    public function destroy($id)
    {
        $temuan = KategoriTemuan::findOrFail($id);
        $temuan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori temuan berhasil dihapus'
        ]);
    }
}
