<?php


namespace App;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FixerClient
{
    private function convertCurrency(Request $request): Response
    {
        try {
            $url = sprintf(
                'http://data.fixer.io/api/convert?access_key=%s&from=%s&to=%s&amount=%s',
                env('FIXER_API_KEY'),
                $request['source_currency'],
                $request['target_currency'],
                $request['value']
            );

            return Http::get($url);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function getCurrencyConverted(Request $request): ?\stdClass
    {
        $currencyConverted = $this->convertCurrency($request);

        try {
            $body = json_decode($currencyConverted->body());

            if (!$body->success) {
                throw new \Exception($body->error->info);
            }

            return $body;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            throw new \Exception($exception->getMessage());
        }
    }
}
