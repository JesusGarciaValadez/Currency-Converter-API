<?php

namespace Database\Factories;

use App\Models\Conversion;
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
        return [
            'source_currency' => $this->faker->currencyCode(),
            'target_currency' => $this->faker->currencyCode(),
            'value' => $this->faker->randomFloat(2, 1, 1000),
            'rate' => $this->faker->randomFloat(2, 1000),
            'timestamp' => Carbon::now(),
            'amount_converted' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
