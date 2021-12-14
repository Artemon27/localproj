<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\offHoursRequest;
use App\Models\off_hours;

class offHoursController extends Controller
{
    //
    public function index() {
        $id = Auth::user()->id;
        $prpsk = Auth::user()->pager;
        $room = Auth::user()->physicalDeliveryOfficeName;
        $phone = Auth::user()->telephoneNumber;
        $now = Carbon::now();

        $dates= off_hours::Where('user_id','=',$id)->get();
        $numdays = 0;

        foreach ($dates as $date){
            $numdays = $numdays+$date->days;
        }
        return view('offHours.index', compact('dates','numdays', 'prpsk', 'room', 'phone'));
    }

    public function store(offHoursRequest $request) //отправка в БД
    {
        $id = Auth::user()->id;
        $now = Carbon::now()->startOfDay();
        off_hours::Where('user_id','=',$id)->Where('allow','=','0')->Where('date','>=',$now)->delete();
        if (isset($request['data'])){
            foreach ($request['data'] as $date){
              $date['date'] = Carbon::createFromFormat('Y-m-d', $date['date'])->startOfDay();
              if($date['date']>=$now){
                $date['user_id'] = $id;
                off_hours::Create($date);
              }
            }
        }

        return back()->with('success', 'Запись на вечер создана');
    }
}
