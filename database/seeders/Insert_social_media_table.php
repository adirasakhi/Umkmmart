<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Insert_social_media_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('social_media')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'facebook' => 'Arka',
                'whatsapp' => '08123456789',
                'tiktok' => 'Arka28',
                'instagram' => '@arka28',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'facebook' => 'Manisan Pala ',
                'whatsapp' => '08234567891',
                'tiktok' => 'manisanpala28',
                'instagram' => '@manisanpala28',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
