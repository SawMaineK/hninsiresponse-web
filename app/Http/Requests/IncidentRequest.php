<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *     schema="IncidentRequest",
 *     required={ "" },
 *     @OA\Property(property="title", type="string", example="Title Example"),
 *     @OA\Property(property="name", type="string", example="Name Example"),
 *     @OA\Property(property="photo", type="string", example="Photo Example"),
 *     @OA\Property(property="post_by_name", type="string", example="Post_by_name Example"),
 *     @OA\Property(property="post_by_phone", type="string", example="Post_by_phone Example"),
 *     @OA\Property(property="post_by_email", type="string", example="Post_by_email Example"),
 *     @OA\Property(property="related_to", type="string", example="Related_to Example"),
 *     @OA\Property(property="condition", type="string", example="Condition Example"),
 *     @OA\Property(property="description", type="string", example="Description Example"),
 *     @OA\Property(property="address", type="string", example="Address Example"),
 *     @OA\Property(property="city_id", type="integer", example="21"),
 *     @OA\Property(property="township_id", type="string", example="Township_id Example"),
 *     @OA\Property(property="country_id", type="integer", example="13"),
 *     @OA\Property(property="latitude", type="string", example="Latitude Example"),
 *     @OA\Property(property="longitude", type="string", example="Longitude Example"),
 *     @OA\Property(property="status", type="string", example="Status Example"),
 *     @OA\Property(property="severity", type="string", example="Severity Example"),
 *     @OA\Property(property="other_condition", type="string", example="Other_condition Example"),
 *     @OA\Property(property="type", type="string", example="Type Example")
 * )
 */

class IncidentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'title'=>'required',
			'name'=>'required',
			'photo'=>'sometimes|file|max:102400',
			'post_by_name'=>'required',
			'post_by_phone'=>'required',
			'post_by_email'=>'',
			'related_to'=>'',
			'condition'=>'',
			'description'=>'',
			'address'=>'',
			'city_id'=>'required',
			'township_id'=>'',
			'country_id'=>'required',
			'latitude'=>'',
			'longitude'=>'',
			'status'=>'required',
			'severity'=>'required',
			'created_at'=>'',
			'updated_at'=>'',
			'other_condition'=>'',
			'type'=>'required',

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
