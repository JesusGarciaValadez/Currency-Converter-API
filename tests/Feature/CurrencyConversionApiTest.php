<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConversionApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assess the API get the right value.
     *
     * @return void
     */
    public function test_assess_the_api_get_the_right_value()
    {
        $sourceCurrency = 'USD';
        $targetCurrency = 'DKK';
        $value = '1000';

        $response = $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);
    }

    /**
     * Assess the API get an error when the source currency is missed.
     *
     * @return void
     */
    public function test_assess_the_api_get_an_error_when_the_source_currency_is_missed()
    {
        $sourceCurrency = '';
        $targetCurrency = 'DKK';
        $value = '1000';

        $response = $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" =>  "The given data was invalid.",
                "errors" => [
                    "source_currency" => [
                        "The source currency field is required."
                    ],
                ],
            ]);
    }

    /**
     * Assess the API get an error when the target currency is missed.
     *
     * @return void
     */
    public function test_assess_the_api_get_an_error_when_the_target_currency_is_missed()
    {
        $sourceCurrency = 'USD';
        $targetCurrency = '';
        $value = '1000';

        $response = $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "target_currency" => [
                        "The target currency field is required."
                    ],
                ],
            ]);
    }

    /**
     * Assess the API get an error when the value is missed.
     *
     * @return void
     */
    public function test_assess_the_api_get_an_error_when_the_value_is_missed()
    {
        $sourceCurrency = 'USD';
        $targetCurrency = 'DKK';
        $value = '';

        $response = $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "value" => [
                        "The value field is required."
                    ],
                ],
            ]);
    }

    /**
     * Assess the API get an error when the value is a string.
     *
     * @return void
     */
    public function test_assess_the_api_get_an_error_when_the_value_is_a_string()
    {
        $sourceCurrency = 'USD';
        $targetCurrency = 'DKK';
        $value = 'test';

        $response = $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "value" => [
                        "The value must be a number.",
                    ],
                ],
            ]);
    }

    /**
     * Assess the API get an error when the source currency have an incorrect currency value.
     *
     * @return void
     */
    public function test_assess_the_api_get_an_error_when_the_source_currency_have_an_incorrect_currency_value()
    {
        $sourceCurrency = 'USR';
        $targetCurrency = 'DKK';
        $value = '1000';
        $error = "You have entered an invalid \"from\" property. [Example: from=EUR]";

        $response = $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "error" => $error,
            ]);
    }

    /**
     * Assess the API get an error when the target currency have an incorrect currency value.
     *
     * @return void
     */
    public function test_assess_the_api_get_an_error_when_the_target_currency_have_an_incorrect_currency_value()
    {
        $sourceCurrency = 'USD';
        $targetCurrency = 'DKN';
        $value = '1000';
        $error = "You have entered an invalid \"to\" property. [Example: to=GBP]";

        $response = $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                "error" => $error,
            ]);
    }

    /**
     * Assess the database has the values stored.
     *
     * @return void
     */
    public function test_assess_the_database_has_the_values_stored()
    {
        $sourceCurrency = 'USD';
        $targetCurrency = 'DKK';
        $value = '1000';

        $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $this->assertDatabaseHas('conversions', [
            'source_currency' => $sourceCurrency,
            'target_currency' => $targetCurrency,
            'value' => $value,
        ]);;
    }

    /**
     * Assess that the database is empty.
     *
     * @return void
     */
    public function test_assess_that_the_database_is_empty()
    {
        $sourceCurrency = 'USD';
        $targetCurrency = 'DKN';
        $value = '1000';

        $this->postJson(
            '/api/currency/conversion',
            [
                'source_currency' => $sourceCurrency,
                'target_currency' => $targetCurrency,
                'value' => $value,
            ]);

        $this->assertDatabaseMissing('conversions', [
            'source_currency' => $sourceCurrency,
            'target_currency' => $targetCurrency,
            'value' => $value,
        ]);;
    }
}
