<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
        if($this->data){
            foreach ($this->data as $data => $value){
                $dates[]=Carbon::createFromFormat('Y-m-d', $value['datefrom']);
                if ($value['days'] < 7){
                    return ['data'=> [
                        function ($attribute, $value, $fail) {
                            $fail('Можно выбирать не менее 7 дней подряд');   
                        }
                    ,]];
                }
            }
            return [
                'data.*.days'=> ['integer'],
                'data.*.PVT'=> ['integer'],
                'data.*.INV'=> ['integer'],
                'data.*.OB'=> ['integer'],
            ];
        }
        else{    
            return [
                //
            ];
        }        
    }
}