<?php

namespace App\Http\Controllers;

use App\Conversion;
use App\Http\Requests\CurrencyConversionRequest;
use App\Enums\HttpResponses;
use Illuminate\Http\JsonResponse;
use \Exception;

class ConversionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Conversion  $conversion
     * @param CurrencyConversionRequest $request
     * @return JsonResponse
     */
    public function store(Conversion $conversion, CurrencyConversionRequest $request): JsonResponse
    {
        try {
            $response = $conversion->processCurrencyConversion($request);

            return response()->json($response, HttpResponses::HTTP_RESPONSE_CREATED);
        } catch (Exception $exception) {
            $response = [ 'error' => $exception->getMessage() ];

            return response()->json($response, HttpResponses::HTTP_RESPONSE_BAD_REQUEST);
        }
    }
}
