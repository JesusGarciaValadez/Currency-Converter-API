<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CountryCurrency;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
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

        array_map(function ($country) {
            Country::create($country);
        }, $countries);
    }
}
