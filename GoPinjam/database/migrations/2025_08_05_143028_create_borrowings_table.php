<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel items
            $table->string('borrower_name'); // Nama peminjam (kita asumsikan user memasukkan manual untuk saat ini)
            $table->text('purpose'); // Tujuan peminjaman
            $table->timestamp('borrowed_at')->useCurrent(); // Waktu peminjaman
            $table->timestamp('returned_at')->nullable(); // Waktu pengembalian (akan diisi nanti)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};