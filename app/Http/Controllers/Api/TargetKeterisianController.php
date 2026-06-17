<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TargetKeterisian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TargetKeterisianController extends Controller
{
    public function index(Request $request)
    {
        $query = TargetKeterisian::with(['lapangan', 'lapangan.cabang']);

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        if ($request->has('cabang_id') && $request->cabang_id != '') {
            $query->whereHas('lapangan', function($q) use ($request) {
                $q->where('cabang_id', $request->cabang_id);
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'tahun' => 'required|integer|min:2000|max:2100',
            'bulan' => 'required|integer|min:1|max:12',
            'target_jam' => 'required|integer|min:1',
            'realisasi_jam' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $target = TargetKeterisian::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Target keterisian berhasil ditambahkan',
            'data' => $target
        ]);
    }
}
