<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Insert_category_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category')->insert([
             [
                'id'=>1,
                'category'=> 'Buah-buahan',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>2,
                'category'=> 'Sayuran',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>3,
                'category'=> 'Daging',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>4,
                'category'=> 'Kerajinan Tangan',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>5,
                'category'=> 'Makanan Olahan',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>6,
                'category'=> 'Herbal',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>7,
                'category'=> 'Kebutuhan Rumah Tangga',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>8,
                'category'=> 'Perkakas',
                'created_at' => now(),
                'updated_at'=> now()
            ],
        ]);
    }
}
