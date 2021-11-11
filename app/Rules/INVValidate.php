<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class INVValidate implements Rule
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
        return !(($value!=2)&&($value!=0));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ИНВ может быть либо 0 либо 2 дня';
    }
}
