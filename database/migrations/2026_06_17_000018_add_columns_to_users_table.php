<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('email');
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->nullOnDelete();
            $table->foreignId('cabang_id')->nullable()->after('role_id')->constrained('cabang')->nullOnDelete();
            $table->foreignId('member_group_id')->nullable()->after('cabang_id')->constrained('member_groups')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['member_group_id']);
            $table->dropForeign(['cabang_id']);
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'cabang_id', 'member_group_id', 'username', 'is_active']);
        });
    }
};
