<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Hapus relasi foreign key dulu
            if (Schema::hasColumn('borrowings', 'user_id')) {
                $table->dropForeign(['user_id']);
            }

            // Ubah kolom user_id menjadi string (untuk menyimpan nama user)
            $table->string('user_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Kembalikan jadi foreignId (integer)
            $table->foreignId('user_id')->nullable()->constrained('users')->change();
        });
    }
};
