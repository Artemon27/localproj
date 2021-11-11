<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Rules\PVTValidate;
use App\Rules\OBValidate;
use App\Rules\INVValidate;

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
        $belka=0;
        if($this->data){
            foreach ($this->data as $data => $value){
                $dates[]=Carbon::createFromFormat('Y-m-d', $value['datefrom']);
                if ($value['days']>=14){
                   $belka=1;
                }
            }
            if (!$belka){
                return ['data'=> [
                        function ($attribute, $value, $fail) {
                            $fail('Один из отпусков должен быть не менее 14 дней');   
                        }
                    ,]];
            }            
            return [
                'data.*.days'=> ['integer','min:7'],
                'data.*.PVT'=> ['integer', new PVTValidate],
                'data.*.INV'=> ['integer', new INVValidate],
                'data.*.OB'=> ['integer', new OBValidate],
            ];
        }
        else{    
            return [
                //
            ];
        }        
    }
    
    public function messages()
{
    return [
        'data.*.days.min' => 'Можно выбирать не менее 7 дней подряд',
    ];
}
}
