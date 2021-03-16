<?php


namespace App;

use App\Models\Conversion as ConversionModel;
use App\FixerClient as Client;
use Illuminate\Http\Request;

class Conversion
{
    public function __construct(
        private Client $client,
        private ConversionRepository $repository
    )
    {
        $this->client = new Client();
        $this->repository = new ConversionRepository(new ConversionModel());
    }

    public function processCurrencyConversion(Request $request): ConversionModel
    {
        $currencyConverted = $this->client->getCurrencyConverted($request);
        return $this->repository->storeCurrencyConverted($currencyConverted);
    }
}
