<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'is_admin' => 1,
                'created_at' => Carbon::parse()
            ]
        ]);

        $userId = DB::table('users')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++){
            DB::table('users')->insert([
                [
                    'name' => Str::random(10),
                    'email' => Str::random(6) . '@gmail.com',
                    'password' => Str::random(10),
                    'is_admin' => 0,
                    'created_at' => Carbon::parse()
                ]
            ]);
        }
    }
}
