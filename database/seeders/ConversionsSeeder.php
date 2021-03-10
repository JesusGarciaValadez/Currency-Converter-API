<?php

namespace Database\Seeders;

use App\Models\Conversions;
use Illuminate\Database\Seeder;

class ConversionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conversions::factory()
            ->count(100)
            ->create();
    }
}
