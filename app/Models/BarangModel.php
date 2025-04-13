<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangModel extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'm_barang';
    
    // Define the primary key
    protected $primaryKey = 'barang_id';
    
    // Disable timestamps if not using created_at/updated_at
    public $timestamps = false;
    
    // Define fillable fields (remove duplicate 'barang_kode')
    protected $fillable = [
        'kategori_id', 
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual'
    ];
    
    // Remove 'barang_id' from fillable as it's auto-incrementing
    
    // Define relationship with UserModel
    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class, 'barang_id', 'barang_id');
    }
    
    // Define relationship with KategoriModel with proper type-hinting
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
    
    // Add casts for numeric fields to ensure proper type handling
    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
    ];
    
    // Optionally add validation rules that can be used in controllers
    public static function rules($id = null): array
    {
        return [
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|min:3|max:20|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_beli',
        ];
    }
}