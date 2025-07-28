<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CountrySeeder::class);
        $this->call(AdminSeeder::class);
        // \App\Models\Rider::factory(10)->create();
        
        // $this->call(EmailTemplateSeeder::class);




        // \App\Models\Admin::factory()->create([
        //     'name' => 'Test Admin',
        //     'email' => 'abhiawasthi5696@gmail.com',
        //     'password' => Hash::make('Admin#0987'),
        //     'role' => 1, 
        // ]);
    }
}
