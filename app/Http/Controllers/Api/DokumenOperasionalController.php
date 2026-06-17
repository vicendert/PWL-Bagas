<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DokumenOperasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokumenOperasionalController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenOperasional::query();

        // Filters
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('unit_pengunggah') && $request->unit_pengunggah != '') {
            $query->where('unit_pengunggah', $request->unit_pengunggah);
        }

        if ($request->has('jabatan_pengunggah') && $request->jabatan_pengunggah != '') {
            $query->where('jabatan_pengunggah', 'LIKE', '%' . $request->jabatan_pengunggah . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['id', 'nama_dokumen', 'tahun', 'kategori', 'unit_pengunggah', 'jabatan_pengunggah'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_dokumen' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2100',
            'kategori' => 'required|in:Kebijakan,Manual,Legalitas,Sistem Informasi',
            'unit_pengunggah' => 'required|in:Cabang,Fakultas,Pusat',
            'jabatan_pengunggah' => 'required|string|max:100',
            'file_dokumen' => 'required|file|mimes:pdf|max:7168', // PDF max 7MB (7 * 1024 = 7168KB)
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->except('file_dokumen');

        if ($request->hasFile('file_dokumen')) {
            $path = $request->file('file_dokumen')->store('dokumen', 'public');
            $data['file_path'] = '/storage/' . $path;
        }

        $dokumen = DokumenOperasional::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diunggah',
            'data' => $dokumen
        ]);
    }

    public function destroy($id)
    {
        $dokumen = DokumenOperasional::findOrFail($id);

        if ($dokumen->file_path) {
            $oldPath = ltrim(str_replace('/storage/', '', parse_url($dokumen->file_path, PHP_URL_PATH)), '/');
            Storage::disk('public')->delete($oldPath);
        }

        $dokumen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus'
        ]);
    }
}
