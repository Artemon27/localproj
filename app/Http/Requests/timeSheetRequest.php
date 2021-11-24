<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class timeSheetRequest extends FormRequest
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
      if(isset($this->time)){
        return $this->time;
      }
      return [
            //
        ];

     //dd($this->data);
      //Надо узнать какие проверки проводить
        /*$belka=0;
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
        }  */
    }
}
