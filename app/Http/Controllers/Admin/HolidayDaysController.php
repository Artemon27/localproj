<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllHoliday;

class HolidayDaysController extends Controller
{
    public function index() {
        
        $dates= AllHoliday::get();
        
        return view('admin.holidayDays.index', compact('dates'));         
        
    }
}
