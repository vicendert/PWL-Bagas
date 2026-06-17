<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RekapKelayakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RekapKelayakanController extends Controller
{
    public function index(Request $request)
    {
        $query = RekapKelayakan::with(['lapangan', 'lapangan.cabang']);

        // Global Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('lapangan', function($q) use ($search) {
                $q->where('nama_lapangan', 'LIKE', '%' . $search . '%')
                  ->orWhere('kode', 'LIKE', '%' . $search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['id', 'target_keterisian_jam', 'nilai_kondisi_mandiri', 'nilai_tim_qc', 'grade', 'bintang'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $rekap = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $rekap
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'target_keterisian_jam' => 'required|integer|min:1',
            'nilai_kondisi_mandiri' => 'required|numeric|min:0|max:100',
            'nilai_tim_qc' => 'required|numeric|min:0|max:100',
            'grade' => 'required|in:A,B,C,D,E',
            'bintang' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $rekap = RekapKelayakan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Rekap kelayakan berhasil ditambahkan',
            'data' => $rekap
        ]);
    }

    public function update(Request $request, $id)
    {
        $rekap = RekapKelayakan::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'target_keterisian_jam' => 'required|integer|min:1',
            'nilai_kondisi_mandiri' => 'required|numeric|min:0|max:100',
            'nilai_tim_qc' => 'required|numeric|min:0|max:100',
            'grade' => 'required|in:A,B,C,D,E',
            'bintang' => 'required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $rekap->update($request->all());
        return response()->json(['success' => true, 'message' => 'Rekap berhasil diperbarui', 'data' => $rekap]);
    }

    public function destroy($id)
    {
        RekapKelayakan::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Rekap berhasil dihapus']);
    }
}
