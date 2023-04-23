<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $senha = 'admin';
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            //'password' => Hash::make('password'),
            'password' => bcrypt($senha),
            'role' => 1, // admin role
        ]);
    }
}
