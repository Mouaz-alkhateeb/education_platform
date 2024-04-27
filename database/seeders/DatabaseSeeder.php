<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Statuses\UserType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


    public function run(): void
    {
        $filename = 'avatar.jpg';
        $path = 'images/' . $filename;

        \App\Models\User::factory()->create([
            "name" => "Super Admin",
            "email" => "superadmin@gmail.com",
            "password" => bcrypt('0123456789'),
            "role" => UserType::SUPER_ADMIN,
            "phone" => "0000000000",
            "image" => $path,

        ]);
    }
}