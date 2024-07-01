<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class insert_banner_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
             [
                'id'=>1,
                'title'=> 'Banner Head',
                'description'=> 'Banner Untuk Tampilan Head',
                'image'=> '-',
                'type'=>'head',
                'created_at' => now(),
                'updated_at'=> now()
            ],
        ]);
    }
}
