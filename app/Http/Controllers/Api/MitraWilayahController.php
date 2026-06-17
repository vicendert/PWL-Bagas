<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MitraWilayahController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Cabang::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $cabang = Cabang::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cabang berhasil ditambahkan',
            'data' => $cabang
        ]);
    }

    public function update(Request $request, $id)
    {
        $cabang = Cabang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $cabang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cabang berhasil diperbarui',
            'data' => $cabang
        ]);
    }

    public function destroy($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cabang berhasil dihapus'
        ]);
    }
}
