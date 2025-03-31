<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *     schema="CityRequest",
 *     required={ "" },
 *     @OA\Property(property="region_id", type="integer", example="5"),
 *     @OA\Property(property="name_en", type="string", example="Name_en Example"),
 *     @OA\Property(property="name_mm", type="string", example="Name_mm Example"),
 *     @OA\Property(property="code", type="string", example="Code Example")
 * )
 */

class CityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'region_id'=>'required',
			'name_en'=>'required',
			'name_mm'=>'required',
			'code'=>'',
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
