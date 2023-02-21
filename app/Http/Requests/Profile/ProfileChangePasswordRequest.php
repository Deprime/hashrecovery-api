<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class ProfileChangePasswordRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'password' => ['required', 'string', 'min:6', 'confirmed'],
      // 'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/'],
      // 'password_confirmation' => ['required', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
    ];
  }

  /**
   * Fail validation response
   * @param Illuminate\Contracts\Validation\Validator
   * @throws Illuminate\Http\Exceptions\HttpResponseException
   */
  protected function failedValidation(Validator $validator) {
    throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNAUTHORIZED));
  }
}
