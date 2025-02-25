<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'level_kategori' => 'Berat', 'nama_kategori' => 'Besi'],
            ['kategori_id' => 2, 'level_kategori' => 'Ringan', 'nama_kategori' => 'Bulu' ],
            ['kategori_id' => 3, 'level_kategori' => 'Agak Berat', 'nama_kategori' => 'Timah'],
            ['kategori_id' => 4, 'level_kategori' => 'Biasa', 'nama_kategori' => 'Kayu' ],
            ['kategori_id' => 5, 'level_kategori' => 'Lumayan', 'nama_kategori' => 'Plastik'],
        ];
            
        DB::table('m_kategori')->insert($data);
    }
}
