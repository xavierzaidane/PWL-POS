<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['detail_id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'harga' => 5500000, 'jumlah' => 1],
            ['detail_id' => 2, 'penjualan_id' => 1, 'barang_id' => 2, 'harga' => 3500000, 'jumlah' => 1],
            ['detail_id' => 3, 'penjualan_id' => 1, 'barang_id' => 3, 'harga' => 150000, 'jumlah' => 1],
            ['detail_id' => 4, 'penjualan_id' => 2, 'barang_id' => 4, 'harga' => 170000, 'jumlah' => 2],
            ['detail_id' => 5, 'penjualan_id' => 2, 'barang_id' => 5, 'harga' => 10000, 'jumlah' => 3],
            ['detail_id' => 6, 'penjualan_id' => 2, 'barang_id' => 1, 'harga' => 5500000, 'jumlah' => 1],
            ['detail_id' => 7, 'penjualan_id' => 3, 'barang_id' => 2, 'harga' => 3500000, 'jumlah' => 2],
            ['detail_id' => 8, 'penjualan_id' => 3, 'barang_id' => 3, 'harga' => 150000, 'jumlah' => 2],
            ['detail_id' => 9, 'penjualan_id' => 3, 'barang_id' => 4, 'harga' => 170000, 'jumlah' => 1],
            ['detail_id' => 10, 'penjualan_id' => 4, 'barang_id' => 5, 'harga' => 10000, 'jumlah' => 4],
            ['detail_id' => 11, 'penjualan_id' => 4, 'barang_id' => 1, 'harga' => 5500000, 'jumlah' => 1],
            ['detail_id' => 12, 'penjualan_id' => 4, 'barang_id' => 2, 'harga' => 3500000, 'jumlah' => 1],
            ['detail_id' => 13, 'penjualan_id' => 5, 'barang_id' => 3, 'harga' => 150000, 'jumlah' => 2],
            ['detail_id' => 14, 'penjualan_id' => 5, 'barang_id' => 4, 'harga' => 170000, 'jumlah' => 2],
            ['detail_id' => 15, 'penjualan_id' => 5, 'barang_id' => 5, 'harga' => 10000, 'jumlah' => 3],
        ];

        DB::table('t_penjualan_detail')->insert($data);
    }
}
