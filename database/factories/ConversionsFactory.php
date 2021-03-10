<?php

namespace Database\Factories;

use App\Models\Conversions;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversions::class;

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
            'amount_converted' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
