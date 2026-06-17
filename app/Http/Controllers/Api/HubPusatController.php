<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HubPusat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HubPusatController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => HubPusat::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_hub' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $hub = HubPusat::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Hub Pusat berhasil ditambahkan',
            'data' => $hub
        ]);
    }

    public function update(Request $request, $id)
    {
        $hub = HubPusat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_hub' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $hub->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Hub Pusat berhasil diperbarui',
            'data' => $hub
        ]);
    }

    public function destroy($id)
    {
        $hub = HubPusat::findOrFail($id);
        $hub->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hub Pusat berhasil dihapus'
        ]);
    }
}
