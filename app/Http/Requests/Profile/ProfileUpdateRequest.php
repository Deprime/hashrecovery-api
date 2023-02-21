<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
      // 'first_name' => ['required', 'string'],
      // 'last_name'  => ['nullable', 'string'],
      'email' => [
        'string',
        'email:rfc,strict',
        Rule::unique('App\Models\User')->ignore($this->user()->id),
      ],
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
