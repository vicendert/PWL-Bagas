<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // ==========================================
    // PORTAL MEMBERS (MEMBER/PENYEWA)
    // ==========================================

    public function indexMembers()
    {
        $members = User::whereHas('role', function ($q) {
            $q->where('name', 'member');
        })->with('memberGroup')->get();

        return response()->json([
            'success' => true,
            'data' => $members
        ]);
    }

    public function storeMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'member_group_id' => 'required|exists:member_groups,id',
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $memberRole = Role::where('name', 'member')->first();
        if (!$memberRole) {
            return response()->json(['success' => false, 'message' => 'Role member tidak ditemukan.'], 400);
        }

        $user = User::create([
            'role_id' => $memberRole->id,
            'member_group_id' => $request->member_group_id,
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil ditambahkan',
            'data' => $user->load('memberGroup')
        ]);
    }

    public function updateMember(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:100|unique:users,username,' . $id,
            'member_group_id' => 'required|exists:member_groups,id',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'member_group_id' => $request->member_group_id,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil diperbarui',
            'data' => $user->load('memberGroup')
        ]);
    }

    public function toggleActiveMember($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'diaktifkan' : 'dikunci';
        return response()->json([
            'success' => true,
            'message' => "Akun member berhasil {$statusStr}.",
            'data' => $user
        ]);
    }

    public function resetPasswordMember(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password member berhasil direset.'
        ]);
    }

    public function destroyMember($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil dihapus.'
        ]);
    }

    // ==========================================
    // BACKOFFICE STAFF (STAFF/STRUKTUR ADMIN)
    // ==========================================

    public function indexStaff()
    {
        $staff = User::whereHas('role', function ($q) {
            $q->where('name', '!=', 'member');
        })->with(['role', 'cabang'])->get();

        return response()->json([
            'success' => true,
            'data' => $staff
        ]);
    }

    public function storeStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'cabang_id' => 'nullable|exists:cabang,id',
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Ensure role is not member
        $role = Role::findOrFail($request->role_id);
        if ($role->name === 'member') {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menambahkan staf dengan role member.'], 400);
        }

        $user = User::create([
            'role_id' => $request->role_id,
            'cabang_id' => $request->cabang_id,
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Staf backoffice berhasil ditambahkan',
            'data' => $user->load(['role', 'cabang'])
        ]);
    }

    public function updateStaff(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:100|unique:users,username,' . $id,
            'role_id' => 'required|exists:roles,id',
            'cabang_id' => 'nullable|exists:cabang,id',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $role = Role::findOrFail($request->role_id);
        if ($role->name === 'member') {
            return response()->json(['success' => false, 'message' => 'Role member tidak diperbolehkan untuk staf backoffice.'], 400);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'cabang_id' => $request->cabang_id,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Staf backoffice berhasil diperbarui',
            'data' => $user->load(['role', 'cabang'])
        ]);
    }

    public function destroyStaff($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staf backoffice berhasil dihapus.'
        ]);
    }
}
