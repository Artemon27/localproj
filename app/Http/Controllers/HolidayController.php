<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\HolidayRequest;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Holidesign;
use App\Models\UserSetting;
use App\Models\Setting;

class HolidayController extends Controller
{
    //
    public function index() {
        $user = Auth::user();
                
        $setting = new Setting;
        $year = $setting->CentralYear();
        $now = Carbon::create($setting->CentralYear()-1);
        $today = Carbon::create($setting->CurrentYear());
        $firstYear = Carbon::create($setting->CentralYear()-1);
        
        $oldDates= Holiday::Where('user_id','=',$user->id)->Where('dateto','>=',$firstYear)->Where('dateto','<',$today)->get();
        
        $dates= Holiday::Where('user_id','=',$user->id)->Where('dateto','>=',$today)->get();
        
        $today = $today->timestamp;
        
        $numdays = 0;
        
        foreach ($dates as $date){
            $date->datefromStr = strtotime($date->datefrom);
            $date->datetoStr = strtotime($date->dateto);
            $numdays = $numdays+$date->days;
        }
        return view('holiday.index', compact('dates','numdays','user','setting','year','today','oldDates'));         
    }
    
    public function store(HolidayRequest $request)
    {
        $user = Auth::user();
        $id = $user->id;
        
        $setting = new Setting;
        $today = Carbon::create($setting->CurrentYear());
        
        Holiday::Where('user_id','=',$id)->Where('allow','=','0')->Where('dateto','>=',$today)->delete();
        
        if (isset($request['data'])){
                foreach ($request['data'] as $date){
                $date['user_id'] = $id;
                $date['datefrom']=Carbon::createFromFormat('Y-m-d', $date['datefrom'])->startOfDay();
                $date['dateto']=$date['datefrom']->copy()->addDays($date['days']-1)->endOfDay();
                Holiday::Create($date);
            }
        }
        
        if ($user->settings){
            $user->settings->design = $request['design'];
            $user->settings->save();
        }
        else{
            $settings = new UserSetting;
            $settings->design = $request['design'];
            $settings->user_id=$id;
            $settings->save();
        }
        
        return back()->with('success', 'Отпуск сохранён');
    }
    
    public function colors() {
        
        $user = Auth::user();
        
        $setting = new Setting;
        $year = $setting->CentralYear();
        $now = Carbon::create($setting->CentralYear()-1);
        $today = Carbon::create($setting->CurrentYear());
        $firstYear = Carbon::create($setting->CentralYear()-1);
        
        $oldDates= Holiday::Where('user_id','=',$user->id)->Where('dateto','>=',$firstYear)->Where('dateto','<',$today)->get();
        
        $id = $user->id;
        
        $dates= Holiday::Where('user_id','=',$user->id)->Where('dateto','>=',$today)->get();
        
        $today = $today->timestamp;
        
        $color = Holidesign::Where('user_id','=',$id)->first();
        if (!isset($color)){
            $color = new Holidesign;
        }
        $numdays = 0;
        foreach ($dates as $date){
            $date->datefromStr = strtotime($date->datefrom);
            $date->datetoStr = strtotime($date->dateto);
            $numdays = $numdays+$date->days;
        }
        
        return view('holiday.colors.index', compact('dates','numdays','color','user','year','today','oldDates'));         
    }
    
    public function addcolors(Request $request) {
        $user = Auth::user();
        $id = $user->id;
        $color = Holidesign::Where('user_id','=',$id)->get();
        $request['user_id'] = $id;
        if(count($color)){
            $color[0]->update($request->all());
        }
        else {
            Holidesign::Create($request->all());
        }
        $cssString = file_get_contents('css/calendarDarkTemp.css');
        foreach ($request->all() as $name=>$setting){            
            $cssString = str_replace('[.'.$name.'.]', $setting, $cssString);
        }
        file_put_contents('css/holiuser/theme_'.$id.'.css', $cssString);
        
        if ($user->settings){
            $user->settings->design = 3;
            $user->settings->save();
        }
        else{
            $settings = new UserSetting;
            $settings->design = 3;
            $settings->user_id=$id;
            $settings->save();
        }
                
        return back();
    }
    
    
    
    public function charts() {
        
        $user = Auth::user();
                
        $users= User::get();
                
        return view('holiday.charts.index', compact('users','user'));         
    }
}
