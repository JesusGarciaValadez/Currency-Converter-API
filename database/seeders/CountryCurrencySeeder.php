<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CountryCurrency;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CountryCurrencySeeder extends Seeder
{
    private function getUniqueCountries(): array
    {
        $countriesRaw = Country::getCountries();
        $countriesFiltered = array_unique($countriesRaw, SORT_REGULAR);
        sort($countriesFiltered);

        return $countriesFiltered;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = $this->getUniqueCountries();
        $currencies = Currency::getCurrencies();

        foreach($countries as $country) {
            $currencyModels = [];

            foreach ($currencies as $currency) {
                if ($country['description'] !== $currency['country']) {
                    continue;
                }

                $currenciesAvailableForThisCountry = array_filter($currencies, function ($actualCurrency) use ($currency) {
                    return $actualCurrency['country'] === $currency['country'];
                });

                $currencyModels = array_map(function ($currency) {
                    return Currency::where('code', $currency['code'])
                        ->orderBy('name', 'desc')
                        ->get();
                }, $currenciesAvailableForThisCountry);
            }

            $countryId = (Country::where('description', $country['description'])->get())[0]->id;
            array_map(function ($currencyModel) use ($countryId) {
                $row = [
                    'countries_id' => $countryId,
                    'currencies_id' => $currencyModel[0]->id,
                ];
                CountryCurrency::create($row);
            }, $currencyModels);
        }
    }
}
