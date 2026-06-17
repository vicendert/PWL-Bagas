<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaranaFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaranaFasilitasController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => SaranaFasilitas::with('lapangan')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'kode_fasilitas' => 'required|string|max:20',
            'nama_unit' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $sarana = SaranaFasilitas::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Sarana Fasilitas berhasil ditambahkan',
            'data' => $sarana
        ]);
    }

    public function update(Request $request, $id)
    {
        $sarana = SaranaFasilitas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'kode_fasilitas' => 'required|string|max:20',
            'nama_unit' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $sarana->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Sarana Fasilitas berhasil diperbarui',
            'data' => $sarana
        ]);
    }

    public function destroy($id)
    {
        $sarana = SaranaFasilitas::findOrFail($id);
        $sarana->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sarana Fasilitas berhasil dihapus'
        ]);
    }
}
