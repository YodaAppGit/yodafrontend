<?php

namespace Database\Seeders;

use App\Models\Penjual;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'vincentiusmandala@gmail.com',
            'password' => bcrypt('Yoda123'),
            'location' => 'Surabaya',
            'user_status' => 'Aktif',
            'phone_number' => '+6281239687792'
        ]);

        $superAdmin->assignRole('Super Admin');

        $superAdmin = User::create([
            'name' => 'Alaikha Annan',
            'email' => 'alaikha.annan@kalachakraconsulting.com',
            'password' => bcrypt('Yoda1234'),
            'location' => 'Jakarta',
            'user_status' => 'Aktif',
            'phone_number' => '+628123123123'
        ]);

        $superAdmin->assignRole('Super Admin');

        $guestExternal = User::create([
            'name' => 'External',
            'email' => 'test@test.com',
            'password' => bcrypt('Test123'),
            'location' => 'Denpasar',
            'user_status' => 'Aktif',
            'phone_number' => '+62123123123'
        ]);

        $guestExternal->assignRole('External');

        Penjual::create([
            'nama' => 'Sumber Jaya Motor',
            'kode' => '#P0001',
            'no_telepon' => '(021) 86614072',
            'alamat' => 'Puri Sentra Niaga Blok A No. 10 Jl. Wiraloka Kalimalang',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bekasi',
            'kecamatan' => 'Rawalumbu'
        ]);
        Penjual::create([
            'nama' => 'Muhammad Farevi',
            'kode' => '#P0003',
            'no_telepon' => '(021) 8892447',
            'alamat' => 'Ruko Sun City Square Blok A No. 42 Jl. M. Hasibuan Margajaya Bekasi Selatan',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Malang',
            'kecamatan' => 'Lowokwaru'
        ]);
    }
}
