<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class CustomDateRangeValidation implements Rule
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
        $dates = explode(' to ', $value);

        if (count($dates) !== 2) {
            return false; // Invalid format
        }

        $startDate = Carbon::createFromFormat('Y/m/d', trim($dates[0]));
        $endDate = Carbon::createFromFormat('Y/m/d', trim($dates[1]));

        return $startDate->lt($endDate);
    }

    public function message()
    {
        return 'The start date must be before the end date.';
    }
}
