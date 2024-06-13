<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Insert_role_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
               DB::table('role')->insert([
             [
                'id'=>1,
                'role'=> 'Admin',
                'created_at' => now(),
                'updated_at'=> now()
            ],
            [
                'id'=>2,
                'role'=> 'Penjual',
                'created_at' => now(),
                'updated_at'=> now()
            ],
        ]);
    }
}
