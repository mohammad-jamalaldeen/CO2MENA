<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class WhiteSpaceRule implements Rule
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


    public function passes($attribute, $value)
    {
        return trim($value) !== '';
    }

    public function message()
    {
        return 'The :attribute must not be empty or contain only whitespace.';
    }
}
