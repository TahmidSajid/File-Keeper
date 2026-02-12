<?php

namespace Database\Seeders\User;

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
        $users = array(
            array('id' => '1', 'firstname' => 'Test','lastname' => 'User','email' => 'test@filekeeper.com', 'image' => NULL, 'email_verified_at' => NULL, 'password' => '$2y$12$oMbOtqHudSDbhHi2nFTdzOC0BtqHrh5pcr7X0lVh9mxDMiGb8PDW2', 'remember_token' => NULL, 'created_at' => '2026-02-12 14:44:27', 'updated_at' => '2026-02-12 14:44:27')
        );


        User::insert($users);
    }
}
