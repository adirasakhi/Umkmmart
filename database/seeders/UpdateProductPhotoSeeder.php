<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateProductPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the photos
        $photos = [
            'img/dodol-sirsak.jpg',
            'img/sirsak.jfif',
            'img/keripik-nangka.jfif',
            'img/nangka.jpg',
            'img/madu.jpg',
            'img/sapu-lidi.jpg',
        ];

        $product = DB::table('product')->get();

        // Assign a photo to each user
        foreach ($product as $index => $product) {
            DB::table('product')
                ->where('id', $product->id)
                ->update(['image' => $photos[$index % count($photos)]]);
        }
    }
}
