<?php

namespace Database\Factories;

use App\Models\Conversion;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currencies = Currency::all();

        return [
            'currencies_id_source' => $currencies->random(),
            'currencies_id_target' => $currencies->random(),
            'value' => $this->faker->randomFloat(2, 1, 1000),
            'rate' => $this->faker->randomFloat(2, 1000),
            'timestamp' => Carbon::now(),
            'amount_converted' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
