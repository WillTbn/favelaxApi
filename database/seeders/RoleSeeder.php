<?php

namespace Database\Seeders;

use App\Models\Ability;
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

        Role::create([
            'name' => 'Master',
        ]);
        Role::create([
            'name' => 'Modeler',
        ]);
        Role::create([
            'name' => 'Financial lvl one',
        ]);
        Role::create([
            'name' => 'Financial lvl two',
        ]);

    }
}
