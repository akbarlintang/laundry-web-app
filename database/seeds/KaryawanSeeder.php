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
        DB::table('karyawan')->insert([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'nama' => 'admin',
            'no_hp' => '081234567890',
            'alamat' => 'admin',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
    }
}
