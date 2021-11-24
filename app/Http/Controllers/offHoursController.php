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
        $room = Auth::user()->physicalDeliveryOfficeName;//*
        $phone = Auth::user()->telephoneNumber;//*


        $now = Carbon::now();

        $dates= off_hours::Where('user_id','=',$id)->Where('date','>',$now)->get();
        $numdays = 0;

        foreach ($dates as $date){
            //$date->date = strtotime($date->date);
            $numdays = $numdays+$date->days;
        }
        return view('offHours.index', compact('dates','numdays', 'prpsk', 'room', 'phone'));
    }

    public function store(offHoursRequest $request) //отправка в БД
    {
        $id = Auth::user()->id;

        $now = Carbon::now();

        off_hours::Where('user_id','=',$id)->Where('allow','=','0')->delete();

        if (isset($request['data'])){
                foreach ($request['data'] as $date){
                $date['user_id'] = $id;
                $date['date']=Carbon::createFromFormat('Y-m-d', $date['date'])->startOfDay();
                off_hours::Create($date);
            }
        }

        return back()->with('success', 'Запись на вечер создана');
    }
}
