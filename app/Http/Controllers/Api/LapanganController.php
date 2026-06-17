<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Lapangan::with(['hubPusat', 'kategoriLapangan', 'cabang'])->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hub_pusat_id' => 'required|exists:hub_pusat,id',
            'kategori_lapangan_id' => 'required|exists:kategori_lapangan,id',
            'cabang_id' => 'required|exists:cabang,id',
            'kode' => 'required|string|max:20|unique:lapangan,kode',
            'nama_lapangan' => 'required|string|max:255',
            'akreditasi' => 'required|in:A,B,C,Unggul',
            'nomor_sk' => 'required|string|max:100',
            'tanggal_sertifikasi' => 'required|date',
            'alamat' => 'nullable|string',
            'dokumen_legalitas' => 'nullable|file|mimes:pdf|max:2048', // PDF Max 2MB
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Image Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->except(['dokumen_legalitas', 'foto']);

        if ($request->hasFile('dokumen_legalitas')) {
            $path = $request->file('dokumen_legalitas')->store('dokumen', 'public');
            $data['dokumen_legalitas'] = '/storage/' . $path;
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('lapangan', 'public');
            $data['foto'] = '/storage/' . $path;
        }

        $lapangan = Lapangan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data lapangan berhasil ditambahkan',
            'data' => $lapangan
        ]);
    }

    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'hub_pusat_id' => 'required|exists:hub_pusat,id',
            'kategori_lapangan_id' => 'required|exists:kategori_lapangan,id',
            'cabang_id' => 'required|exists:cabang,id',
            'kode' => 'required|string|max:20|unique:lapangan,kode,' . $id,
            'nama_lapangan' => 'required|string|max:255',
            'akreditasi' => 'required|in:A,B,C,Unggul',
            'nomor_sk' => 'required|string|max:100',
            'tanggal_sertifikasi' => 'required|date',
            'alamat' => 'nullable|string',
            'dokumen_legalitas' => 'nullable|file|mimes:pdf|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->except(['dokumen_legalitas', 'foto']);

        if ($request->hasFile('dokumen_legalitas')) {
            if ($lapangan->dokumen_legalitas) {
                $oldPath = ltrim(str_replace('/storage/', '', parse_url($lapangan->dokumen_legalitas, PHP_URL_PATH)), '/');
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('dokumen_legalitas')->store('dokumen', 'public');
            $data['dokumen_legalitas'] = '/storage/' . $path;
        }

        if ($request->hasFile('foto')) {
            if ($lapangan->foto) {
                $oldPath = ltrim(str_replace('/storage/', '', parse_url($lapangan->foto, PHP_URL_PATH)), '/');
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('foto')->store('lapangan', 'public');
            $data['foto'] = '/storage/' . $path;
        }

        $lapangan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data lapangan berhasil diperbarui',
            'data' => $lapangan
        ]);
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        if ($lapangan->dokumen_legalitas) {
            $oldPath = ltrim(str_replace('/storage/', '', parse_url($lapangan->dokumen_legalitas, PHP_URL_PATH)), '/');
            Storage::disk('public')->delete($oldPath);
        }

        if ($lapangan->foto) {
            $oldPath = ltrim(str_replace('/storage/', '', parse_url($lapangan->foto, PHP_URL_PATH)), '/');
            Storage::disk('public')->delete($oldPath);
        }

        $lapangan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data lapangan berhasil dihapus'
        ]);
    }
}
