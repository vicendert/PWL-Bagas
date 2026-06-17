<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StandarFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StandarFasilitasController extends Controller
{
    public function index()
    {
        // Get parent nodes (root items) with their children ordered by 'urutan'
        $data = StandarFasilitas::with('children')
            ->whereNull('parent_id')
            ->orderBy('urutan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable|exists:standar_fasilitas,id',
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string', // Rich text editor output (HTML)
            'jenis_indikator' => 'required|in:kuantitatif,kualitatif',
            'bobot_kelayakan' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Set urutan
        $maxUrutan = StandarFasilitas::where('parent_id', $request->parent_id)->max('urutan');
        $urutan = ($maxUrutan !== null) ? $maxUrutan + 1 : 0;

        $sf = StandarFasilitas::create(array_merge($request->all(), ['urutan' => $urutan]));

        return response()->json([
            'success' => true,
            'message' => 'Standar Fasilitas berhasil ditambahkan',
            'data' => $sf
        ]);
    }

    public function updateUrutan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:standar_fasilitas,id',
            'orders.*.urutan' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        foreach ($request->orders as $order) {
            StandarFasilitas::where('id', $order['id'])->update(['urutan' => $order['urutan']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan standar fasilitas berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $sf = StandarFasilitas::findOrFail($id);
        $sf->delete();

        return response()->json([
            'success' => true,
            'message' => 'Standar Fasilitas berhasil dihapus'
        ]);
    }
}
