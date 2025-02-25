<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 3, 'pembeli' => 'John Doe', 'penjualan_kode' => 'PJ001', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 2, 'user_id' => 1, 'pembeli' => 'Jane Smith', 'penjualan_kode' => 'PJ002', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 3, 'user_id' => 2, 'pembeli' => 'Alice Johnson', 'penjualan_kode' => 'PJ003', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 4, 'user_id' => 3, 'pembeli' => 'Michael Brown', 'penjualan_kode' => 'PJ004', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 5, 'user_id' => 1, 'pembeli' => 'Emily Davis', 'penjualan_kode' => 'PJ005', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 6, 'user_id' => 2, 'pembeli' => 'David Wilson', 'penjualan_kode' => 'PJ006', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 7, 'user_id' => 3, 'pembeli' => 'Sophia Martinez', 'penjualan_kode' => 'PJ007', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 8, 'user_id' => 1, 'pembeli' => 'James Anderson', 'penjualan_kode' => 'PJ008', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 9, 'user_id' => 2, 'pembeli' => 'Isabella Thomas', 'penjualan_kode' => 'PJ009', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 10, 'user_id' => 3, 'pembeli' => 'Benjamin Taylor', 'penjualan_kode' => 'PJ010', 'penjualan_tanggal' => Carbon::now()],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
