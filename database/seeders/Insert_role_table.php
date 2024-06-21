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
        $role = [
            'admin',
            'penjual',
        ];

        foreach ($role as $roles) {
            DB::table('role')->insert([
                'role' => $roles,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
