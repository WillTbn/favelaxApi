<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Financial;
use App\Models\Modeler;
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

        Admin::create([
            'name' => 'User admin',
            'email' => env('USER_ADMIN_EMAIL', 'admin@gmail.com'),
            'password' => bcrypt(env('USER_ADMIN_PASSWORD', '12345678'))
        ]);

        User::create([
            'name' => 'User Low',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456')
        ]);
        Modeler::create([
            'name' => 'User Modeler',
            'email' => 'modeler@gmail.com',
            'password' => bcrypt('123456')
        ]);
        Financial::create([
            'name' => 'User Financial',
            'email' => 'financial@gmail.com',
            'password' => bcrypt('123456'),
            'level' => 'delete'
        ]);
        \App\Models\User::factory(20)->create();
    }
}
