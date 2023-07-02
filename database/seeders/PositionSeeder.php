<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ['Manager','General Manager','Staff'];

        foreach ($items as $key => $item) {
            Position::create([
                'position'  => $item
            ]);
        }
    }
}
