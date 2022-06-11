<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karyawans')->insert([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'nama' => 'Admin',
            'no_hp' => '081234567890',
            'alamat' => 'Jalan jalan',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
    }
}
