<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id', 
        'purpose',
        'borrowed_at',
        'returned_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Get the item that owns the borrowing.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user that owns the borrowing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}