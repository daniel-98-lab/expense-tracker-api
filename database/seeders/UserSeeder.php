<?php

namespace Database\Seeders;

use App\Infrastructure\Models\User as ModelsUser;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsUser::create([
            'name' => env('USER_NAME', 'Default Name'),
            'email' => env('USER_EMAIL', 'default@example.com'),
            'password' => (env('USER_PASSWORD', 'defaultpassword')),
        ]);
    }
}
