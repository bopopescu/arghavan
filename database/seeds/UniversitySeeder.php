<?php

use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\University::create([
            'name' => 'فنی و مهندسی',
        ]);

        \App\University::create([
            'name' => 'علوم پایه',
        ]);
    }
}
