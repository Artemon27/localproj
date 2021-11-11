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
        $belka=0;
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
                if(($value['PVT']!=5)&&($value['PVT']!=0)){
                    return ['data'=> [
                        function ($attribute, $value, $fail) {
                            $fail('ПВТ может быть либо 0 либо 5 дней');   
                        }
                    ,]];
                }
                if(($value['INV']!=2)&&($value['INV']!=0)){
                    return ['data'=> [
                        function ($attribute, $value, $fail) {
                            $fail('ИНВ может быть либо 0 либо 2 дня');   
                        }
                    ,]];
                }
                if(($value['OB']!=2)&&($value['OB']!=4)&&($value['OB']!=0)){
                    return ['data'=> [
                        function ($attribute, $value, $fail) {
                            $fail('ОБ может быть либо 0 либо 2 либо 4 дня');   
                        }
                    ,]];
                }
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
