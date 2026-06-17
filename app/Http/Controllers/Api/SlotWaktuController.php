<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SlotWaktu;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SlotWaktuController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => SlotWaktu::with('lapangan')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tipe_slot' => 'required|in:Reguler,Turnamen,Perawatan',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $slot = SlotWaktu::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Slot waktu berhasil ditambahkan',
            'data' => $slot
        ]);
    }

    public function destroy($id)
    {
        $slot = SlotWaktu::findOrFail($id);

        // Proteksi database ketat: Data waktu tidak dapat dihapus jika masih mengikat data transaksi atau pemesanan aktif di lapangan tersebut
        $pemesananAktif = Pemesanan::where('slot_waktu_id', $id)
            ->where('status', 'Aktif')
            ->exists();

        if ($pemesananAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus! Slot waktu ini masih terikat dengan pemesanan aktif.'
            ], 400);
        }

        $slot->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slot waktu berhasil dihapus'
        ]);
    }
}
