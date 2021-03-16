<?php


namespace App;

use App\Models\Conversion as ConversionModel;
use App\Models\Currency;
use \Exception;
use \stdClass;

class ConversionRepository
{
    public function __construct (
        private ConversionModel $conversionModel
    ) {
        $this->model = $conversionModel;
    }

    private function getCurrencyInformation(stdClass $currencyConverted): void
    {
        $this->model['currencies_id_source'] = (int) (Currency::firstWhere('code', $currencyConverted->query->from))->id;
        $this->model['currencies_id_target'] = (int) (Currency::firstWhere('code', $currencyConverted->query->to))->id;
        $this->model['value'] = (string) $currencyConverted->query->amount;
        $this->model['amount_converted'] = (string) $currencyConverted->result;
        $this->model['rate'] = (string) $currencyConverted->info->rate;
        $this->model['timestamp'] = (string) $currencyConverted->info->timestamp;
    }

    private function mapResponse(stdClass $currencyConverted): array
    {
        return $response = [
            'source_currency' => (string) (Currency::firstWhere('code', $currencyConverted->query->from))->code,
            'target_currency' => (string) (Currency::firstWhere('code', $currencyConverted->query->to))->code,
            'value' => (string) $currencyConverted->query->amount,
            'amount_converted' => (string) $currencyConverted->result,
            'rate' => (string) $currencyConverted->info->rate,
            'timestamp' => (string) $currencyConverted->info->timestamp,
        ];
    }

    public function storeCurrencyConverted(stdClass $currencyConvertedResponse): array
    {
        $this->getCurrencyInformation($currencyConvertedResponse);

        if (!$this->model->save()) {
            throw new Exception('Conversion was not recorded.');
        }

        return $this->mapResponse($currencyConvertedResponse);
    }
}
