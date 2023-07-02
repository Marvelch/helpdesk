<?php

namespace Database\Seeders;

use App\Models\typeOfWork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ['Maintenance','Network','Software','Training'];

        foreach ($items as $key => $item) {
            typeOfWork::create([
                'typeofwork'  => $item
            ]);
        }
    }
}
