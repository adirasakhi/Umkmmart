<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            Insert_category_table::class,
            Insert_role_table::class,
            Insert_social_media_table::class,
            Insert_users_table::class,
            Insert_product_table::class,
            // Seeder lainnya jika ada
        ]);
    }
}
