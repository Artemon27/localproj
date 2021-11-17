<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Setting;
use Carbon\Carbon;

class CurDateValidate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        
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
        $setting = new Setting;
        $today = Carbon::create($setting->CurrentYear());
        $curTime = Carbon::create($value);
        if ($today <= $curTime){
            return 1;
        }
        else{
            return 0;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Неправильный выбор дат';
    }
}
