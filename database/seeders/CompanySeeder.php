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

        foreach ($items as $key => $item) {
            company::create([
                'company' => $item
            ]);
        }
    }
}
