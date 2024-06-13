<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Insert_product_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product')->insert([
             [
                'id'=>1,
                'name'=> 'Dodol sirsak',
                'price'=> 25000,
                'description'=> 'Olahan Tradisional dodol yang tebuat dari buah sirsak yang segar',
                'image'=> '-',
                'category_id'=>5,
                'seller_id'=> 2,
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>2,
                'name'=> 'Sirsak',
                'price'=> 15000,
                'description'=> 'Sirsak Segar dengan cita rasa manis asam',
                'image'=> '-',
                'category_id'=>1,
                'seller_id'=> 2,
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>3,
                'name'=> 'Keripik Nangka',
                'price'=> 28000,
                'description'=> 'Camilan Renyah dan enak yang terbuat dari nangka pilihan yang di olah dengan higienis dengan harga ekonomis',
                'image'=> '-',
                'category_id'=>5,
                'seller_id'=> 2,
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>4,
                'name'=> 'Nangka',
                'price'=> 13000,
                'description'=> 'Buah Nangka manis',
                'image'=> '-',
                'category_id'=>1,
                'seller_id'=> 2,
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>5,
                'name'=> 'Madu Murni',
                'price'=> 128000,
                'description'=> 'madu murni untuk meningkatkan daya tahan tubuh: Madu mengandung antioksidan yang membantu melawan radikal bebas dan meningkatkan sistem kekebalan tubuh',
                'image'=> '-',
                'category_id'=>6,
                'seller_id'=> 2,
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>6,
                'name'=> 'Sapu Lidi',
                'price'=> 8000,
                'description'=> 'Sapu lidi adalah alat kebersihan tradisional yang terbuat dari lidi aren (daun aren yang dikeringkan) yang diikat menjadi satu kesatuan. Sapu lidi umumnya digunakan untuk membersihkan lantai, halaman, dan area lain dari kotoran dan debu.',
                'image'=> '-',
                'category_id'=>7,
                'seller_id'=> 2,
                'created_at' => now(),
                'updated_at'=> now()
            ],
        ]);
    }
}
