<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class Insert_users_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        [   'id'=>1,
            'name'=> 'Arka',
            'email'=> 'arka@gmail.com',
            'password'=>Hash::make('arka123'),
            'address'=> 'Jl.Terusan BCA NO.28',
            'photo'=> '/assets/photo.jpeg',
            'phone'=> '08123456789',
            'social_media_id'=>1,
            'role_id'=>1,
            'email_verified_at'=>now(),
            'remember_token'=>Hash::make('arka123'),
            'created_at' => now(),
            'updated_at'=> now()
        ],
        [
            'id'=>2,
            'name'=> 'Enung Nurjanah',
            'email'=> 'enung@gmail.com',
            'password'=>Hash::make('enung123'),
            'address'=> 'Jl.Terusan BCA NO.12',
            'photo'=> '/assets/photo1.jpeg',
            'phone'=> '08234567891',
            'social_media_id'=>2,
            'role'=>2,
            'email_verified_at'=>now(),
            'remember_token'=>Hash::make('enung123'),
            'created_at' => now(),
            'updated_at'=> now()
        ],
        ]);
    }
}
