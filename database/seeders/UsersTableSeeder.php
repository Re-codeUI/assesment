<?php

namespace Database\Seeders;

use App\Models\User; // Pastikan menggunakan namespace User yang benar
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin
        $admin = User::factory()->create([
            'name'     => 'RecodeUI',
            'email'    => 'recodeui@kassesment.com',
            'email_verified_at' => now(),
            'password' => bcrypt('secret001'),
        ]);

        $admin->assignRole('admin');

        $this->command->info('>_ Here is your admin details to login:');
        $this->command->warn($admin->email);
        $this->command->warn('Password is "secret001"');

        // guru
        $guru = User::factory()->create([
            'name'     => 'guru',
            'email'    => 'guru@kassesment.com',
            'email_verified_at' => now(),
            'password' => bcrypt('secret001'),
        ]);

        $guru->assignRole('guru');

        $this->command->info('>_ Here is your guru details to login:');
        $this->command->warn($guru->email);
        $this->command->warn('Password is "secret001"');

        // siswa
        $siswa = User::factory()->create([
            'name'     => 'siswa',
            'email'    => 'siswa@kassesment.com',
            'email_verified_at' => now(),
            'password' => bcrypt('secret001'),
        ]);

        $siswa->assignRole('siswa');

        $this->command->info('>_ Here is your siswa details to login:');
        $this->command->warn($siswa->email);
        $this->command->warn('Password is "secret001"');

        // bersihkan cache
        $this->command->call('cache:clear');
    }
}
