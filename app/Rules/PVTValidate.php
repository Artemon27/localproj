<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PVTValidate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       return !(($value!=5)&&($value!=0));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ПВТ может быть либо 0 либо 5 дней';
    }
}
