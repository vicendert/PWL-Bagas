<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MusimOperasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MusimOperasionalController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => MusimOperasional::orderBy('tahun', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|integer|min:2000|max:2100|unique:musim_operasional,tahun',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // If status is Aktif, set other seasons to Tidak Aktif (only one active season at a time is common practice)
        if ($request->status === 'Aktif') {
            MusimOperasional::query()->update(['status' => 'Tidak Aktif']);
        }

        $musim = MusimOperasional::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Musim operasional berhasil ditambahkan',
            'data' => $musim
        ]);
    }

    public function update(Request $request, $id)
    {
        $musim = MusimOperasional::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tahun' => 'required|integer|min:2000|max:2100|unique:musim_operasional,tahun,' . $id,
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        if ($request->status === 'Aktif') {
            MusimOperasional::where('id', '!=', $id)->update(['status' => 'Tidak Aktif']);
        }

        $musim->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Musim operasional berhasil diubah',
            'data' => $musim
        ]);
    }

    public function destroy($id)
    {
        $musim = MusimOperasional::findOrFail($id);

        // Kunci tombol hapus jika status musim sedang 'Aktif'
        if ($musim->status === 'Aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Musim operasional yang sedang Aktif tidak dapat dihapus!'
            ], 400);
        }

        $musim->delete();

        return response()->json([
            'success' => true,
            'message' => 'Musim operasional berhasil dihapus'
        ]);
    }
}
