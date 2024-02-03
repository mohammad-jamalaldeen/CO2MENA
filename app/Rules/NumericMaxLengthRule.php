<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class NumericMaxLengthRule implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    // public function validate(string $attribute, mixed $value, Closure $fail): void
    // {
    //     //
    // }
    private $maxLength;

    public function __construct($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    public function passes($attribute, $value)
    {
        return is_numeric($value) && strlen((string) $value) == $this->maxLength;
    }

    public function message()
    {
        return "The contact number may not be greater than $this->maxLength digits.";
    }
}
