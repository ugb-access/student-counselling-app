<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'counsellor',
            ],
            [
                'name' => 'student',
            ],
        ];

        foreach($posts as $key => $value) {
            Role::create($value);
        }
    }
}
