<?php


namespace App;

use App\CurrencyRepository;
use App\Models\Conversions as ConversionsModel;
use App\FixerClient as Client;
use Illuminate\Http\Request;

class Conversions
{
    public function __construct(
        private Client $client,
        private CurrencyRepository $repository
    )
    {
        $this->client = new Client();
        $this->repository = new CurrencyRepository(new ConversionsModel());
    }

    public function processCurrencyConversion(Request $request): ConversionsModel
    {
        $currencyConverted = $this->client->getCurrencyConverted($request);
        $result = $this->repository->storeCurrencyConverted($currencyConverted);

        if (empty($result)) {
            throw new \Exception('The currency was not converted.');
        }

        return $result;
    }
}
