<?php

namespace App\Http\Controllers;

use App\Conversions;
use App\Http\Requests\CurrencyConversionRequest;
use App\Enums\HttpResponses;
use Illuminate\Http\JsonResponse;

class ConversionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CurrencyConversionRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Conversions $conversions, CurrencyConversionRequest $request): JsonResponse
    {
        try {
            $response = $conversions->processCurrencyConversion($request);

            return response()->json($response, HttpResponses::HTTP_RESPONSE_CREATED);
        } catch (\Exception $exception) {
            $response = [ 'error' => $exception->getMessage() ];

            return response()->json($response, HttpResponses::HTTP_RESPONSE_BAD_REQUEST);
        }
    }
}
