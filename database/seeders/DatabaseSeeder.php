<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' =>'Admin User',
                'email' => env('USER_ADMIN_EMAIL', 'admin@gmail.com'),
                'password' => bcrypt(env('USER_ADMIN_PASSWORD', '12345678')),
                'email_verified_at' => now(),
                'role' =>  'admin'
            ],
            [
                'name' =>'Moderador User',
                'email' => 'modelador@gmail.com',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
                'role' =>  'modelador'
            ],
            [
                'name' =>'Financeiro Nvl One',
                'email' => 'financeiro_one@gmail.com',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
                'role' =>  'FinanceiroFirst'
            ],
            [
                'name' =>'Financeiro Nvl One',
                'email' => 'financeiro_two@gmail.com',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
                'role' =>  'FinanceiroSecond'
            ],
            [
                'name' =>'User low',
                'email' => 'user@gmail.com',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
                'role' => 'low'
            ]
        ];
        // \App\Models\User::factory(10)->create();

        foreach($users as $user){
            User::create($user);
        }

    }
}
