<?php

namespace App\Http\Requests\Admin;

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
                $dates[]=Carbon::createFromTimestamp($data);
                $this->numdays++;
            }
            $sliced = array_slice($dates, 1);
            $k=1;
            $i=0;            
            if (count($sliced)){
                foreach ($sliced as $index => $date){
                    if ($k==1){
                        $dateArr[$i]['datefrom']=Carbon::create($dates[$index])->startOfDay();     
                    }
                    if ($date->isSameDay($dates[$index]->addDay())){
                        $k++;
                    }
                    else{ 
                        $k=1;        
                        $dateArr[$i]['dateto']=$dates[$index]->subDay()->endOfDay();
                        $i++;
                    }   
                }      
                if ($k==1){
                    $dateArr[$i]['datefrom']=Carbon::create($dates[$index+1])->startOfDay();
                }
                $dateArr[$i]['dateto']=$dates[$index+1]->endOfDay();
            }
            else{
                $dateArr[$i]['datefrom']=Carbon::create($dates[0])->startOfDay();     
                $dateArr[$i]['dateto']=$dateArr[$i]['datefrom'];
            }            
            $this->dateArr = $dateArr;
            return [
                //
            ];
        }
        return [
                //
            ];
    }
}
