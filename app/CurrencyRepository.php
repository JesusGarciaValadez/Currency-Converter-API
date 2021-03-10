<?php


namespace App;

use App\Models\Conversions as ConversionsModel;
use \Exception;
use \stdClass;

class CurrencyRepository
{
    public function __construct (
        private ConversionsModel $conversionsModel
    ) {
        $this->model = $conversionsModel;
    }

    public function storeCurrencyConverted(stdClass $currencyConvertedResponse): ConversionsModel
    {
        $this->model['source_currency'] = $currencyConvertedResponse->query->from;
        $this->model['target_currency'] = $currencyConvertedResponse->query->to;
        $this->model['value'] = (string) $currencyConvertedResponse->query->amount;
        $this->model['amount_converted'] = (string) $currencyConvertedResponse->result;

        if (!$this->model->save()) {
            throw new Exception('Conversion was not recorded.');
        }

        return $this->model;
    }
}
