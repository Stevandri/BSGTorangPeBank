<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Pastikan kolom 'borrower_name' ada sebelum menghapusnya
            if (Schema::hasColumn('borrowings', 'user_id')) { //todayganti
                $table->dropColumn('user_id'); //todayganti
            }

            // Tambahkan foreign key 'user_id' jika belum ada
            if (!Schema::hasColumn('borrowings', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('item_id')->constrained('users');
            }
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Tambahkan kembali 'borrower_name' jika 'user_id' akan di-rollback
            if (!Schema::hasColumn('borrowings', 'borrower_name')) {
                $table->string('borrower_name')->nullable()->after('item_id');
            }

            // Hapus foreign key 'user_id' jika ada
            if (Schema::hasColumn('borrowings', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};