<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbilitySeeder extends Seeder
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

        Ability::create([
            'name' => 'access-all',
            'role_id' => $master->id
        ]);
        Ability::create([
            'name' => 'read-users',
            'role_id' => $modeler->id
        ]);
        Ability::create([
            'name' => 'delete-users',
            'role_id' => $lvlOne->id
        ]);
        Ability::create([
            'name' => 'update-users',
            'role_id' => $lvlTwo->id
        ]);
    }
}
