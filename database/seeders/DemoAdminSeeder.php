<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoAdminSeeder extends Seeder
{
    /**
     * Seed a demo company and an Admin user for testing purposes.
     */
    public function run(): void
    {
        if (DB::table('users')->where('email', 'admin@semberk.tech')->exists()) {
            $this->command->info('Demo Admin already exists — skipping.');
            return;
        }

        $now = now()->toDateTimeString();
        $companyId = DB::table('companies')->insertGetId([
            'name'       => 'Semberk',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('users')->insert([
            'name'       => 'Semberk Admin',
            'email'      => 'admin@semberk.tech',
            'password'   => Hash::make('semberk@123'),
            'role'       => 'Admin',
            'company_id' => $companyId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->command->info('Demo Admin seeded: admin@semberk.tech / semberk@123');
    }
}
