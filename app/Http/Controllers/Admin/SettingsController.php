<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index() {
        
        $settings = Setting::get();
        return view('admin.settings.index', compact('settings'));         
    }
    
    public function store(Request $request){
        unset($request['_token']);
        $options = $request->all();      
        foreach($options as $option => $setting){
            Setting::Where('option','=',$option)->update(['value'=>$setting]);
        }
        return back();
    }
}
