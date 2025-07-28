<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin#0987'),
            'role' => 1, 
        ]);
    }
}
