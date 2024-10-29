<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'  => 'Admin',
            'email' => 'admin@amdacademy.id',
            'password'  => Hash::make('password')
        ]);

        $user->markEmailAsVerified();

        $user->assignRole('admin');
    }
}
