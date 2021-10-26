<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait StandardizedResponse
{
    public function successResponse($data, $code)
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    public function feedbackResponse($message, $code)
     {
         return response()->json(['message' => $message], $code);
     }

    public function unprocessableResponse($code = Response::HTTP_UNPROCESSABLE_ENTITY)
     {
         $message = 'An error occured and your request could not be processed. Please try again later';
        return response($message, $code)->header('Content-Type', 'application/json');
     }
}