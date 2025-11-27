<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import SoftDeletes
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    use HasFactory, SoftDeletes; // 2. Pakai Trait SoftDeletes

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'is_default'
    ];

    // 3. Mutator & Accessor (Fitur baru Laravel 9+)
    protected function name(): Attribute
    {
        return Attribute::make(
            // Get: Saat diambil dari DB, ubah huruf depan jadi besar
            get: fn($value) => ucwords($value),
            // Set: Saat disimpan ke DB, ubah jadi huruf kecil semua
            set: fn($value) => strtolower($value),
        );
    }

    // 4. Logic Cascading Soft Delete
    // Saat kategori dihapus, transaksi terkait ikut terhapus (soft delete)
    protected static function booted()
    {
        static::deleting(function ($category) {
            // Hapus semua transaksi milik kategori ini
            $category->transactions()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
