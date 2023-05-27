<?php

namespace Database\Seeders;

use App\Models\company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = ['SKB','BPU'];

        for ($i=0; $i > count($items); $i++) { 
            company::create([
                'company' => $items[$i]
            ]);
        }
    }
}
