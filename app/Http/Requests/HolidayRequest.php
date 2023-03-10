<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Rules\PVTValidate;
use App\Rules\OBValidate;
use App\Rules\INVValidate;
use App\Rules\FourteenValidate;
use App\Rules\CurDateValidate;

class HolidayRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {          
        return [
            'data'=> [new FourteenValidate],
            'data.*.datefrom' => [new CurDateValidate],
            'data.*.days'=> ['integer','min:7'],
            'data.*.PVT'=> ['integer', new PVTValidate],
            'data.*.INV'=> ['integer', new INVValidate],
            'data.*.OB'=> ['integer', new OBValidate],
            'design'=>['integer','min:0', 'max:3'],
        ]; 
    }
    
    public function messages()
{
    return [
        'data.*.days.min' => 'Можно выбирать не менее 7 дней подряд',
    ];
}
}
