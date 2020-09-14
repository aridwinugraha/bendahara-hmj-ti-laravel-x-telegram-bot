<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['npk'=>'HMJ/TI/XIV/17-18/227','name' =>'ari dwi', 'name_last'=>'nugraha', 'username'=>'admin web', 'email'=>'arinugraha56@gmail.com', 'password' => Hash::make('0p3r4v4nj4v4'), 'level'=>'admin', 'jk'=>'Laki-laki', 'agama'=>'islam', 'status_anggota'=>'Pengurus Harian', 'username_telegram'=>'aridwi56', 'chat_id'=>'404893430', 'no_hp'=>'085814487401', 'remember_token'=>'BdeXwSb6AnKIIC9m3O9OZhkZWmc1Bz5p95nrZE4ELsZMSMDuitOyjF9f0rLL']
       ]);
    }
}
