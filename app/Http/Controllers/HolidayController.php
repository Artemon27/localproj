<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\HolidayRequest;
use App\Models\Holiday;

class HolidayController extends Controller
{
    //
    public function index() {
        $id = Auth::user()->id;
        
        $now = Carbon::now();
        
        $dates= Holiday::Where('user_id','=',$id)->Where('dateto','>',$now)->get();
        
        $numdays = 0;
        
        foreach ($dates as $date){
            $date->datefromStr = strtotime($date->datefrom);
            $date->datetoStr = strtotime($date->dateto);
            $numdays = $numdays+$date->days;
        }
        return view('holiday.index', compact('dates','numdays'));         
    }
    
    public function store(HolidayRequest $request)
    {
        $id = Auth::user()->id;
        
        $now = Carbon::now();
        
        Holiday::Where('user_id','=',$id)->Where('allow','=','0')->Where('datefrom','>',$now)->delete();

        foreach ($request['data'] as $date){
            $date['user_id'] = $id;
            $date['datefrom']=Carbon::createFromFormat('Y-m-d', $date['datefrom'])->startOfDay();
            $date['dateto']=$date['datefrom']->copy()->addDays($date['days']-1)->endOfDay();
            Holiday::Create($date);
        }
        return back()->with('success', 'Отпуск обновлён');
    }
}
