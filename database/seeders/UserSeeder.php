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
        User::create([
            "name" => "Govinda Kharisma Dewa",
            "email" => "govindakharisma10@gmail.com",
            "password" => bcrypt("govinda123")
        ]);
        User::create([
            "name" => "Riska Febriyanti",
            "email" => "riskacomel@gmail.com",
            "password" => bcrypt("riska123")
        ]);
    }
}
