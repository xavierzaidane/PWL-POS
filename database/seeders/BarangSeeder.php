<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Besi', 'kategori_id' => 2, 'harga_beli' => 50000, 'harga_jual' => 60000],
            ['barang_id' => 2, 'barang_kode' => 'BRG002', 'barang_nama' => 'Bulu', 'kategori_id' => 1, 'harga_beli' => 1000, 'harga_jual' => 2000],
            ['barang_id' => 3, 'barang_kode' => 'BRG003', 'barang_nama' => 'Timah', 'kategori_id' => 3, 'harga_beli' => 75000, 'harga_jual' => 85000],
            ['barang_id' => 4, 'barang_kode' => 'BRG004', 'barang_nama' => 'Kayu', 'kategori_id' => 4, 'harga_beli' => 20000, 'harga_jual' => 25000],
            ['barang_id' => 5, 'barang_kode' => 'BRG005', 'barang_nama' => 'Plastik', 'kategori_id' => 2, 'harga_beli' => 15000, 'harga_jual' => 18000],
            ['barang_id' => 6, 'barang_kode' => 'BRG006', 'barang_nama' => 'Baja', 'kategori_id' => 5, 'harga_beli' => 100000, 'harga_jual' => 120000],
            ['barang_id' => 7, 'barang_kode' => 'BRG007', 'barang_nama' => 'Pasir', 'kategori_id' => 1, 'harga_beli' => 5000, 'harga_jual' => 7000],
            ['barang_id' => 8, 'barang_kode' => 'BRG008', 'barang_nama' => 'Tanah', 'kategori_id' => 3, 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 9, 'barang_kode' => 'BRG009', 'barang_nama' => 'Mika', 'kategori_id' => 4, 'harga_beli' => 12000, 'harga_jual' => 15000],
            ['barang_id' => 10, 'barang_kode' => 'BRG010', 'barang_nama' => 'Beton', 'kategori_id' => 2, 'harga_beli' => 90000, 'harga_jual' => 110000],
        ];
        
        DB::table('m_barang')->insert($data);
        
        
        
    }
}
