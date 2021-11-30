<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class MainController extends Controller
{
    public function index() {        
        $user=Auth::user();
        $menus = Menu::orderBy('sort')->get();
        return view('menu.index', compact('menus','user'));         
    }
}
