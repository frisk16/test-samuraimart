<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['ROLE_ADMIN', 'ROLE_GENERAL'];

        foreach($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
