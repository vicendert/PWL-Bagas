<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StafQC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StafQCController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => StafQC::with(['cabang', 'lapangan'])->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:50|unique:staf_qc,nik',
            'nama_staf' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan' => 'required|string|max:100',
            'cabang_id' => 'required|exists:cabang,id',
            'lapangan_id' => 'required|exists:lapangan,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $staf = StafQC::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Staf QC berhasil ditambahkan',
            'data' => $staf
        ]);
    }

    public function destroy($id)
    {
        $staf = StafQC::findOrFail($id);
        $staf->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staf QC berhasil dihapus'
        ]);
    }
}
