<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => "Admin",
          'email' => "admin@example.com",
          'email_verified_at' => now(),
          'password' => Hash::make("password"),
          'remember_token' => Str::random(10),
        ]);

        User::first()->assignRole('Admin');
    }
}
