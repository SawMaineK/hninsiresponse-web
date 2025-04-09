<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *     schema="CountryRequest",
 *     required={ "" },
 *     @OA\Property(property="name", type="string", example="Name Example"),
 *     @OA\Property(property="iso_code", type="string", example="Iso_code Example"),
 *     @OA\Property(property="phone_code", type="string", example="Phone_code Example"),
 *     @OA\Property(property="currency", type="string", example="Currency Example")
 * )
 */

class CountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name'=>'required',
			'iso_code'=>'required',
			'phone_code'=>'',
			'currency'=>'',
			'created_at'=>'',
			'updated_at'=>'',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $response = [
            'code' => 400,
            'message' => "There is something wrong in your request.",
            'errors' => $errors,
        ];
        throw new HttpResponseException(response()->json($response, 400));
    }

}
