<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MusimOperasionalController;
use App\Http\Controllers\Api\MitraWilayahController;
use App\Http\Controllers\Api\HubPusatController;
use App\Http\Controllers\Api\LapanganController;
use App\Http\Controllers\Api\SaranaFasilitasController;
use App\Http\Controllers\Api\DokumenOperasionalController;
use App\Http\Controllers\Api\TarifSkemaController;
use App\Http\Controllers\Api\StandarFasilitasController;
use App\Http\Controllers\Api\SlotWaktuController;
use App\Http\Controllers\Api\TargetKeterisianController;
use App\Http\Controllers\Api\StafQCController;
use App\Http\Controllers\Api\KategoriTemuanController;
use App\Http\Controllers\Api\RekapKelayakanController;
use App\Http\Controllers\Api\UserController;
use App\Models\Role;
use App\Models\MemberGroup;
use App\Models\Cabang;
use App\Models\KategoriLapangan;
use App\Models\HubPusat;
use App\Models\Lapangan;

// ─── SPA Entry Point ────────────────────────────────────────────────────────
Route::get('/', function () { return view('welcome'); });
Route::get('/{any}', function () { return view('welcome'); })->where('any', '^(?!api).*$');

// ─── Auth ────────────────────────────────────────────────────────────────────
Route::post('/api/login',  [AuthController::class, 'login']);
Route::post('/api/logout', [AuthController::class, 'logout']);

// ─── Dashboard ───────────────────────────────────────────────────────────────
Route::get('/api/dashboard', [DashboardController::class, 'index']);

// ─── Musim Operasional ───────────────────────────────────────────────────────
Route::get   ('/api/musim',        [MusimOperasionalController::class, 'index']);
Route::post  ('/api/musim',        [MusimOperasionalController::class, 'store']);
Route::put   ('/api/musim/{id}',   [MusimOperasionalController::class, 'update']);
Route::delete('/api/musim/{id}',   [MusimOperasionalController::class, 'destroy']);

// ─── Mitra Wilayah (Cabang) ──────────────────────────────────────────────────
Route::get   ('/api/mitra',        [MitraWilayahController::class, 'index']);
Route::post  ('/api/mitra',        [MitraWilayahController::class, 'store']);
Route::put   ('/api/mitra/{id}',   [MitraWilayahController::class, 'update']);
Route::delete('/api/mitra/{id}',   [MitraWilayahController::class, 'destroy']);

// ─── Hub Pusat ───────────────────────────────────────────────────────────────
Route::get   ('/api/hub',          [HubPusatController::class, 'index']);
Route::post  ('/api/hub',          [HubPusatController::class, 'store']);
Route::put   ('/api/hub/{id}',     [HubPusatController::class, 'update']);
Route::delete('/api/hub/{id}',     [HubPusatController::class, 'destroy']);

// ─── Lapangan ────────────────────────────────────────────────────────────────
Route::get   ('/api/lapangan',     [LapanganController::class, 'index']);
Route::post  ('/api/lapangan',     [LapanganController::class, 'store']);
Route::put   ('/api/lapangan/{id}',[LapanganController::class, 'update']);
Route::delete('/api/lapangan/{id}',[LapanganController::class, 'destroy']);

// ─── Sarana Fasilitas ────────────────────────────────────────────────────────
Route::get   ('/api/sarana',       [SaranaFasilitasController::class, 'index']);
Route::post  ('/api/sarana',       [SaranaFasilitasController::class, 'store']);
Route::put   ('/api/sarana/{id}',  [SaranaFasilitasController::class, 'update']);
Route::delete('/api/sarana/{id}',  [SaranaFasilitasController::class, 'destroy']);

// ─── Dokumen Operasional ─────────────────────────────────────────────────────
Route::get   ('/api/dokumen',      [DokumenOperasionalController::class, 'index']);
Route::post  ('/api/dokumen',      [DokumenOperasionalController::class, 'store']);
Route::delete('/api/dokumen/{id}', [DokumenOperasionalController::class, 'destroy']);

// ─── Tarif Skema ─────────────────────────────────────────────────────────────
Route::get   ('/api/tarif',        [TarifSkemaController::class, 'index']);
Route::post  ('/api/tarif',        [TarifSkemaController::class, 'store']);
Route::delete('/api/tarif/{id}',   [TarifSkemaController::class, 'destroy']);

// ─── Standar Fasilitas ───────────────────────────────────────────────────────
Route::get   ('/api/standar',              [StandarFasilitasController::class, 'index']);
Route::post  ('/api/standar',              [StandarFasilitasController::class, 'store']);
Route::post  ('/api/standar/urutan',       [StandarFasilitasController::class, 'updateUrutan']);
Route::delete('/api/standar/{id}',         [StandarFasilitasController::class, 'destroy']);

// ─── Slot Waktu ──────────────────────────────────────────────────────────────
Route::get   ('/api/slot',         [SlotWaktuController::class, 'index']);
Route::post  ('/api/slot',         [SlotWaktuController::class, 'store']);
Route::delete('/api/slot/{id}',    [SlotWaktuController::class, 'destroy']);

// ─── Target Keterisian ───────────────────────────────────────────────────────
Route::get   ('/api/target',       [TargetKeterisianController::class, 'index']);
Route::post  ('/api/target',       [TargetKeterisianController::class, 'store']);

// ─── Staf QC ─────────────────────────────────────────────────────────────────
Route::get   ('/api/staf-qc',      [StafQCController::class, 'index']);
Route::post  ('/api/staf-qc',      [StafQCController::class, 'store']);
Route::delete('/api/staf-qc/{id}', [StafQCController::class, 'destroy']);

// ─── Kategori Temuan ─────────────────────────────────────────────────────────
Route::get   ('/api/temuan',       [KategoriTemuanController::class, 'index']);
Route::post  ('/api/temuan',       [KategoriTemuanController::class, 'store']);
Route::delete('/api/temuan/{id}',  [KategoriTemuanController::class, 'destroy']);

// ─── Rekap Kelayakan ─────────────────────────────────────────────────────────
Route::get   ('/api/rekap',        [RekapKelayakanController::class, 'index']);
Route::post  ('/api/rekap',        [RekapKelayakanController::class, 'store']);

// ─── User Management ─────────────────────────────────────────────────────────
Route::get   ('/api/users/member',                  [UserController::class, 'indexMembers']);
Route::post  ('/api/users/member',                  [UserController::class, 'storeMember']);
Route::put   ('/api/users/member/{id}',             [UserController::class, 'updateMember']);
Route::post  ('/api/users/member/{id}/toggle',      [UserController::class, 'toggleActiveMember']);
Route::post  ('/api/users/member/{id}/reset-pass',  [UserController::class, 'resetPasswordMember']);
Route::delete('/api/users/member/{id}',             [UserController::class, 'destroyMember']);

Route::get   ('/api/users/staff',                   [UserController::class, 'indexStaff']);
Route::post  ('/api/users/staff',                   [UserController::class, 'storeStaff']);
Route::put   ('/api/users/staff/{id}',              [UserController::class, 'updateStaff']);
Route::delete('/api/users/staff/{id}',              [UserController::class, 'destroyStaff']);

// ─── Lookup helpers ──────────────────────────────────────────────────────────
Route::get('/api/lookup/roles',     fn() => response()->json(Role::where('name', '!=', 'member')->get()));
Route::get('/api/lookup/member-groups', fn() => response()->json(MemberGroup::all()));
Route::get('/api/lookup/cabang',    fn() => response()->json(Cabang::all()));
Route::get('/api/lookup/kategori',  fn() => response()->json(KategoriLapangan::all()));
Route::get('/api/lookup/hub',       fn() => response()->json(HubPusat::all()));
Route::get('/api/lookup/lapangan',  fn() => response()->json(Lapangan::with(['cabang','kategoriLapangan'])->get()));
