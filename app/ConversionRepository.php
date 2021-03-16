<?php


namespace App;

use App\Models\Conversion as ConversionModel;
use \Exception;
use \stdClass;

class ConversionRepository
{
    public function __construct (
        private ConversionModel $conversionModel
    ) {
        $this->model = $conversionModel;
    }

    public function storeCurrencyConverted(stdClass $currencyConvertedResponse): ConversionModel
    {
        $this->model['source_currency'] = $currencyConvertedResponse->query->from;
        $this->model['target_currency'] = $currencyConvertedResponse->query->to;
        $this->model['value'] = (string) $currencyConvertedResponse->query->amount;
        $this->model['amount_converted'] = (string) $currencyConvertedResponse->result;
        $this->model['rate'] = (string) $currencyConvertedResponse->info->rate;
        $this->model['timestamp'] = (string) $currencyConvertedResponse->info->timestamp;

        if (!$this->model->save()) {
            throw new Exception('Conversion was not recorded.');
        }

        return $this->model;
    }
}
