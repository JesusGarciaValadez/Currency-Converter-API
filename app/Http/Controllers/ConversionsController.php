<?php

namespace App\Http\Controllers;

use App\Conversions;
use App\Http\Requests\CurrencyConversionRequest;
use App\Enums\HttpResponses;
use Illuminate\Http\JsonResponse;
use \Exception;

class ConversionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Conversions  $conversions
     * @param CurrencyConversionRequest $request
     * @return JsonResponse
     */
    public function store(Conversions $conversions, CurrencyConversionRequest $request): JsonResponse
    {
        try {
            $response = $conversions->processCurrencyConversion($request);

            return response()->json($response, HttpResponses::HTTP_RESPONSE_CREATED);
        } catch (Exception $exception) {
            $response = [ 'error' => $exception->getMessage() ];

            return response()->json($response, HttpResponses::HTTP_RESPONSE_BAD_REQUEST);
        }
    }
}
