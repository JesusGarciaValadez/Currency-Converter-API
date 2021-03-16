<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    private function getUniqueCurrencies()
    {
        $currenciesRaw = Currency::getCurrencies();
        $currencies = array_map(function ($currency) {
            unset($currency['country']);

            return $currency;
        }, $currenciesRaw);
        $currenciesFiltered = array_unique($currencies, SORT_REGULAR);
        sort($currenciesFiltered);

        return $currenciesFiltered;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = $this->getUniqueCurrencies();

        array_map(function ($currency) {
            Currency::create($currency);
        }, $currencies);
    }
}
