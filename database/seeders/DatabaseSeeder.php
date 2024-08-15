<?php

namespace Database\Seeders;

use App\Models\Division;
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
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '08123456789',
            'email' => 'admin@admin.com',
            'password' => 'pastibisa'
        ]);

        $this->call([
            DivisionSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
