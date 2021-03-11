<?php


namespace App;

use App\Models\Conversions as ConversionsModel;
use App\FixerClient as Client;
use Illuminate\Http\Request;

class Conversions
{
    public function __construct(
        private Client $client,
        private ConversionsRepository $repository
    )
    {
        $this->client = new Client();
        $this->repository = new ConversionsRepository(new ConversionsModel());
    }

    public function processCurrencyConversion(Request $request): ConversionsModel
    {
        $currencyConverted = $this->client->getCurrencyConverted($request);
        return $this->repository->storeCurrencyConverted($currencyConverted);
    }
}
