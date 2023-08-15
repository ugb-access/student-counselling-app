<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Royal Vision',
            'email' => 'royal_vision@gmail.com',
            'username' => 'royalvis',
            'password' => bcrypt('royalvis'),
            'role_id' => 1
        ]);
    }
}
