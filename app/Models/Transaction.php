<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'category_id',
        'amount',
        'type',
        'description',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    // Relasi ke Dompet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class)->withTrashed(); // withTrashed agar jika dompet dihapus, history tetap ada
    }

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    // Fitur Filter
    public function scopeFilter($query, array $filters)
    {
        // Filter by Month (Format YYYY-MM)
        if (isset($filters['date']) && $filters['date'] != '') {
            $query->where('date', 'like', '%' . $filters['date'] . '%');
        }

        // Filter by Category
        if (isset($filters['category_id']) && $filters['category_id'] != '') {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter by Wallet
        if (isset($filters['wallet_id']) && $filters['wallet_id'] != '') {
            $query->where('wallet_id', $filters['wallet_id']);
        }
    }
}
