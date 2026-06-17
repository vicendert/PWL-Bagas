<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\KategoriLapangan;
use App\Models\User;
use App\Models\TargetKeterisian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Calculate main statistics widgets
        $jumlahPenyewa = User::whereHas('role', function($q) {
            $q->where('name', 'member');
        })->count();

        $jumlahMitra = Cabang::count();
        $jumlahKategori = KategoriLapangan::count();

        // Query metrics for Chart with filters
        $query = TargetKeterisian::query()->with('lapangan');

        if ($request->has('cabang_id') && $request->cabang_id != '') {
            $query->whereHas('lapangan', function($q) use ($request) {
                $q->where('cabang_id', $request->cabang_id);
            });
        }

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->whereHas('lapangan', function($q) use ($request) {
                $q->where('kategori_lapangan_id', $request->kategori_id);
            });
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $targets = $query->get();

        // Occupancy calculation: (realisasi_jam / target_jam) * 100%
        $chartData = $targets->map(function ($target) {
            $occupancy = $target->target_jam > 0 
                ? round(($target->realisasi_jam / $target->target_jam) * 100, 2) 
                : 0;

            return [
                'lapangan' => $target->lapangan->nama_lapangan ?? 'Unknown',
                'bulan' => $target->bulan,
                'target' => $target->target_jam,
                'realisasi' => $target->realisasi_jam,
                'okupansi' => $occupancy
            ];
        });

        return response()->json([
            'success' => true,
            'stats' => [
                'jumlah_penyewa' => $jumlahPenyewa,
                'jumlah_mitra' => $jumlahMitra,
                'jumlah_kategori' => $jumlahKategori,
            ],
            'chart_data' => $chartData
        ]);
    }
}
