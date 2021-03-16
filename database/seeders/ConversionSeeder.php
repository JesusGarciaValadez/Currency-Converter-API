<?php

namespace Database\Seeders;

use App\Models\Conversion;
use Illuminate\Database\Seeder;

class ConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conversion::factory()
            ->count(100)
            ->create();
    }
}
