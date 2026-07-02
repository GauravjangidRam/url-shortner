<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $password = \Illuminate\Support\Facades\Hash::make('password');
        $now = now()->toDateTimeString();

        \Illuminate\Support\Facades\DB::statement(
            "INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES ('Super Admin', 'superadmin@example.com', '{$password}', 'SuperAdmin', '{$now}', '{$now}')"
        );
    }
}
