<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'username' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'nama_lengkap' => 'superadmin',
            'user_created_at' => now()->toDateTimeString(),
            'user_created_by' => '1'
        ]);
        
        User::create([
            'username' => 'kasir',
            'password' => Hash::make('kasir'),
            'nama_lengkap' => 'kasir',
            'user_created_at' => now()->toDateTimeString(),
            'user_created_by' => '1'
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
