<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'John Morton',
            'email' => 'user@example.com',
            'password' => bcrypt('secret'),
            'role' => 1 # User
        ]);

        \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'role' => 2 # Admin
        ]);
    }
}
