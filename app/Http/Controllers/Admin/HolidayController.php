<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\Admin\HolidayRequest;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function index() {
        $id = 1;
        
        $now = Carbon::now();
        
        $dates= Holiday::Where('user_id','=',$id)->Where('dateto','>',$now)->get();
        
        $numdays = 0;
        
        foreach ($dates as $date){
            $date->datefromStr = strtotime($date->datefrom);
            $date->datetoStr = strtotime($date->dateto);
            $numdays = $numdays+$date->days;
        }
        return view('admin.holidays.index', compact('dates','numdays'));         
    }
    
    public function store(HolidayRequest $request)
    {
        $id = 1;
        
        $now = Carbon::now();
        
        Holiday::Where('user_id','=',$id)->Where('allow','=','0')->Where('datefrom','>',$now)->delete();
        if ($request->dateArr){
            foreach($request->dateArr as $date){
                $date['user_id'] = $id;
                $date['days'] = $date['datefrom']->diffInDays($date['dateto'])+1;
                Holiday::Create($date);
            }
        }
        
        return back()->with('success', 'Отпуск обновлён');
    }
}
