<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert(
            [
                [
                    'name' => 'open',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'inprogress',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'resolve',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'close',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );
    }
}
