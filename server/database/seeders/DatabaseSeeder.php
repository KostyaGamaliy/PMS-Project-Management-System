<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class
        ]);

        Project::factory(8)->create();
        User::factory(11)->create();

        //\App\Models\User::factory(10)->create();
        //\App\Models\User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com'
        //]);
    }
}
