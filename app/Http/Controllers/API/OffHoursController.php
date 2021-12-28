<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\offHoursRequest;
use App\Models\off_hours;
use App\Models\User;
use App\Http\Resources\OffhoursResource;
use App\Http\Resources\UserResource;

class OffHoursController extends Controller
{
    public function show(Request $request) {
        $data = $request->json()->all();
        $rules = [
            'date' => 'required|date_format:d.m.Y',
            'days' => 'required|integer'
        ];
        $messages = ['date.required' => 'Дата не заполнена', 'date.date_format' => 'Ошибка даты', 'date.after_or_equal' => 'Можно записываться только на текущую или будущую дату',
            'days.required' => 'Не заполнено количество дней', 'days.integer' => 'Количество дней должно быть целым числом'];
        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->errors()->has('days')){
            $data['days'] = 1;
        }        
        if ($validator->errors()->has('date')){
            $from = Carbon::today()->startOfDay();
            $to = Carbon::today()->startOfDay()->addDays($data['days']);
        }
        else{
            $from = Carbon::createFromFormat('d.m.Y', $data['date'])->startOfDay();
            $to = Carbon::createFromFormat('d.m.Y', $data['date'])->startOfDay()->addDays($data['days']);
        }
        
        $user = $request->user();
        return OffhoursResource::collection($user->get_offhours_days($from,$to));
    }
    
    public function store(Request $request) //отправка в БД
    {
        $data = $request->json()->all();
        $rules = [
            'date' => 'required|date_format:d.m.Y|after_or_equal:today'
        ];
        $messages = ['date.required' => 'Дата не заполнена', 'date.date_format' => 'Ошибка даты', 'date.after_or_equal' => 'Можно записываться только на текущую или будущую дату'];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->passes()) {
            $user = $request->user();
            $from = ['pager','physicalDeliveryOfficeName','telephoneNumber'];
            $to = ['prpsk','room','phone'];
            foreach($to as $key => $value){
                if (!isset($data[$value])){
                    $data[$value] = $user->{$from[$key]};
                }
            }
            $data['date'] = Carbon::createFromFormat('d.m.Y', $data['date'])->startOfDay();
            $data['user_id'] = $user->id;
            off_hours::updateOrCreate(['user_id' => $user->id, 'allow' => '0', 'date' => $data['date']],$data);
            return Response::json(array(
                'status' => 'success'));      
        }
        return Response::json(array(
            'status' => 'error',
            'messages' => $validator->errors()->all()));
    }    
    
    public function delete(Request $request)
    {
        $data = $request->json()->all();
        $rules = [
            'date' => 'required|date_format:d.m.Y|after_or_equal:today'
        ];
        $messages = ['date.required' => 'Дата не заполнена', 'date.date_format' => 'Ошибка даты', 'date.after_or_equal' => 'Можно записываться только на текущую или будущую дату'];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->passes()) {
            $date = Carbon::createFromFormat('d.m.Y', $data['date'])->startOfDay();
            $id = $request->user()->id;
            
            off_hours::Where('user_id','=',$id)->Where('date','=',$date)->delete();            
            return Response::json(array(
                'status' => 'success'));     
        }
        return Response::json(array(
            'status' => 'error',
            'messages' => $validator->errors()->all()));
    }
    
    public function showDay(Request $request) {
        $data = $request->json()->all();
        $rules = [
            'date' => 'required|date_format:d.m.Y'
        ];
        $validator = Validator::make($data, $rules);
        
        if ($validator->passes()) {
            $date = Carbon::createFromFormat('d.m.Y', $data['date'])->startOfDay();
        }
        else{
            $date = Carbon::today()->startOfDay();
        }
        $offhours = off_hours::Where('date','=',$date)->get();    
        $users = collect();
        foreach ($offhours as $offhour){                
            $users->push($offhour->user);
        }
        return UserResource::collection($users);
    }
}
