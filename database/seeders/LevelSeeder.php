<?php

namespace Database\Seeders;

use App\Models\level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $level = ['admin','editor','normal'];
        $special_character = ['110','111','112'];

        if(count($level) == count($special_character)){
            for ($i=0; $i < count($level); $i++) { 
                level::create([
                    'special_character' => $special_character[$i],
                    'level' => $level[$i]
                ]);
            }
        }
    }
}
