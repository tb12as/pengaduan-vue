<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
        	'name' => 'Syafiq Afifuddin',
        	'email' => 'admin@gmail.com',
        	'username' => 'admin',
        	'password' => bcrypt('1234'),
        ]);

        $admin->attachRole('admin');

        $masyarakat = User::create([
            'name' => 'Masyarakat',
            'nik' => '786826828784234',
            'telp' => '083888138138',
            'email' => 'masyarakat@gmail.com',
            'username' => 'masyarakat',
            'password' => bcrypt('1234'),
        ]);

        $masyarakat->attachRole('masyarakat');


        $masyarakat2 = User::create([
            'name' => 'Masyarakat 2',
            'nik' => '878738168648',
            'telp' => '123197',
            'email' => 'masyarakat2@gmail.com',
            'username' => 'masyarakat2',
            'password' => bcrypt('1234'),
        ]);

        $masyarakat2->attachRole('masyarakat');


        $petugas = User::create([
            'name' => 'Petugas',
            'email' => 'petugas@gmail.com',
            'username' => 'petugas',
            'password' => bcrypt('1234'),
        ]);

        $petugas->attachRole('petugas');

    }
}
