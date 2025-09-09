<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unique_code',
        'qr_code_path',
    ];

    //============peminjaman aktif bro======================
    public function activeBorrowing(): HasOne{
        return $this->hasOne(Borrowing::class)->whereNull('returned_at');
    }
}