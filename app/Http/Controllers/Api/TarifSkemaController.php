<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TarifSkema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TarifSkemaController extends Controller
{
    public function index(Request $request)
    {
        $query = TarifSkema::with('cabang');

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        if ($request->has('cabang_id') && $request->cabang_id != '') {
            $query->where('cabang_id', $request->cabang_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cabang_id' => 'required|exists:cabang,id',
            'tahun' => 'required|integer|min:2000|max:2100',
            'nilai_tarif' => 'required|numeric|min:0',
            'deskripsi_skema_jam' => 'required|string|max:255',
            'periode' => 'required|string|max:255',
            'lokasi_lapangan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $skema = TarifSkema::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Skema tarif berhasil ditambahkan',
            'data' => $skema
        ]);
    }

    public function destroy($id)
    {
        $skema = TarifSkema::findOrFail($id);
        $skema->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skema tarif berhasil dihapus'
        ]);
    }
}
