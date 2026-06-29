<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'employee@worknest.com'],
            ['name' => 'Employee John', 'password' => bcrypt('password'), 'role' => 'Employee']
        );

        \App\Models\Document::create([
            'user_id' => $user->id,
            'name' => 'Employee Handbook 2026.pdf',
            'category' => 'Policies',
            'file_path' => 'dummy1.pdf',
            'size' => '2.4 MB',
            'status' => 'Pending Signature',
            'requires_signature' => true
        ]);

        \App\Models\Document::create([
            'user_id' => $user->id,
            'name' => 'Office Lease Agreement.pdf',
            'category' => 'Contracts',
            'file_path' => 'dummy2.pdf',
            'size' => '5.5 MB',
            'status' => 'Expiring Soon',
            'requires_signature' => false
        ]);
    }
}
