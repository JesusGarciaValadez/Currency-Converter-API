<?php


namespace App;

use App\CurrencyRepository;
use App\Models\Conversions as ConversionsModel;
use App\FixerClient as Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use \Exception;

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
        try {
            $currencyConverted = $this->client->getCurrencyConverted($request);
            $result = $this->repository->storeCurrencyConverted($currencyConverted);

            if (empty($result)) {
                throw new \Exception('The currency was not converted.');
            }

            return $result;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }
}
