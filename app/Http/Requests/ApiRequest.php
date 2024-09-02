<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    /**
     * Failed auth override
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     *
     * @return never
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json(
                [
                'message' => 'you are not authorized to do this.'
                ], 403
            )
        );
    }
}
