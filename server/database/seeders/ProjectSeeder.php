<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('projects')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++){
            DB::table('projects')->insert([
                [
                    'name' => Str::random(10),
                    'descriptions' => Str::random(30),
                    'created_at' => Carbon::parse()
                ]
            ]);
        }
    }
}
