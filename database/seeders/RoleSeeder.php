<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	'admin', 'petugas', 'masyarakat'
        ];

        foreach ($roles as $key => $role) {
        	Role::create([
        		'name' => $role,
        		'display_name' => ucfirst($role),
        	]);
        }
    }
}
