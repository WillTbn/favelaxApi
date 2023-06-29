<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Financial;
use App\Models\Modeler;
use App\Models\Role;
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
        $master = Role::where('name', 'Master')->first();
        $modeler= Role::where('name', 'Modeler')->first();
        $lvlOne = Role::where('name', 'Financial lvl one')->first();
        $lvlTwo = Role::where('name', 'Financial lvl two')->first();

        Admin::create([
            'name' => 'User admin',
            'email' => env('USER_ADMIN_EMAIL', 'admin@gmail.com'),
            'password' => bcrypt(env('USER_ADMIN_PASSWORD', '12345678')),
            'role_id'=> $master->id
        ]);
        Admin::create([
            'name' => 'Modeler User',
            'email' => 'modeler@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id'=> $modeler->id
        ]);
        Admin::create([
            'name' => 'Financeiro One Lvl',
            'email' => 'finone@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id'=> $lvlOne->id
        ]);
        Admin::create([
            'name' => 'Financeiro Two Lvl',
            'email' => 'fintwo@gmail.com',
            'password' => bcrypt('12345678'),
            'role_id'=> $lvlTwo->id
        ]);

        User::create([
            'name' => 'User Low',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456')
        ]);
        \App\Models\User::factory(20)->create();
    }
}
