<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array(
            array('id' => '1', 'firstname' => 'Test', 'lastname' => 'User', 'email' => 'test@filekeeper.com', 'image' => NULL, 'email_verified_at' => NULL, 'password' => Hash::make('TKS141???'), 'remember_token' => NULL, 'created_at' => '2026-02-12 14:44:27', 'updated_at' => '2026-02-12 14:44:27')
        );


        Admin::insert($users);
    }
}
