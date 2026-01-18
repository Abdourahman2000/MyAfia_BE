<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Mohamed Zaki',
            'email' => 'mohamed.zaki@cnss.dj',
            'password' => 'test',
            'temp_password' => 0,
            'place' => 'DEV/DBA',
            'type' => 'super_admin',
            'blocked_status' => null,
            'blocked_reason' => null,
            'taken_by' => 'Mohamed Zaki',
            'last_login_at' => null,
            'photo' => null,
            'email_verified_at' => now(),
        ]);


        $user = User::create([
            'name' => 'Rahma Mahdi',
            'email' => 'rahma.mahdi@cnss.dj',
            'password' => 'test',
            'temp_password' => 0,
            'place' => 'dev_dba',
            'type' => 'admin',
            'blocked_status' => null,
            'blocked_reason' => null,
            'taken_by' => 'Mohamed Zaki',
            'last_login_at' => null,
            'photo' => null,
            'email_verified_at' => now(),
        ]);
        $user = User::create([
            'name' => 'Saher Abdillahi Issa',
            'email' => 'saher.abdillahi@cnss.dj',
            'password' => 'test',
            'temp_password' => 0,
            'place' => 'dev_dba',
            'type' => 'admin',
            'blocked_status' => null,
            'blocked_reason' => null,
            'taken_by' => 'Mohamed Zaki',
            'last_login_at' => null,
            'photo' => null,
            'email_verified_at' => now(),
        ]);
        $user = User::create([
            'name' => 'Ahmed Abdou Djama',
            'email' => 'ahmed.abdou@cnss.dj',
            'password' => 'test',
            'temp_password' => 0,
            'place' => 'dev_dba',
            'type' => 'admin',
            'blocked_status' => null,
            'blocked_reason' => null,
            'taken_by' => 'Mohamed Zaki',
            'last_login_at' => null,
            'photo' => null,
            'email_verified_at' => now(),
        ]);
    }
}