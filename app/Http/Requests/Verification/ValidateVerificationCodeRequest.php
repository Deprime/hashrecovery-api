<?php

namespace App\Http\Requests\Verification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

use App\ValueObjects\{
  PhonePrefix,
};

class ValidateVerificationCodeRequest extends FormRequest
{
  protected const PHONE_MODEL = 'App\Models\User';
  protected const CODE_MODEL  = 'App\Models\SmsCode';

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
    $prefix = $this->prefix;
    $phone  = $this->phone;
    $length = $prefix ? PhonePrefix::getLengthByPrefix($prefix) : 9;

    $phone_rules = ['required', "digits:$length"];
    $code_rules  = ['required', 'digits:4'];

    if ($prefix && $phone) {
      // Restore case - exists
      // Other cases - unique
      $rule = ($this->flag === 'restore')
        ? Rule::exists(static::PHONE_MODEL)
        : Rule::unique(static::PHONE_MODEL);

      $rule = $rule->where(function ($query) use ($prefix) {
        return $query->where('prefix', $prefix);
      });

      $phone_rules[] = $rule;

      // Additional validation code rule
      $code_rules[] = Rule::exists(static::CODE_MODEL)
        ->where(function ($query) use ($prefix, $phone) {
          return $query->where('prefix', $prefix)->where('phone', $phone);
        });
    }

    return [
      'flag'   => ['nullable', 'string'],
      'prefix' => ['required', 'string', Rule::in(PhonePrefix::prefixList())],
      'code'   => $code_rules,
      'phone'  => $phone_rules,
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
