<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => env('USER_NAME', 'Default Name'),
            'email' => env('USER_EMAIL', 'default@example.com'),
            'password' => Hash::make(env('USER_PASSWORD', 'defaultpassword')),
        ]);
    }
}
