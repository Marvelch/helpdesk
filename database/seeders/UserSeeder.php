<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'bapak it',
            'username'          => 'bapakitku',
            'email'             => NULL,
            'level_id'          => 1,
            'phone'             => NULL,
            'email_verified_at' => NULL,
            'company_id'        => NULL,
            'position_id'       => NULL,
            'password'          => Hash::make('%%Makeit99%%'),
            'password_text'     => NULL,
            'division_id'       => NULL
        ]);
    }
}
