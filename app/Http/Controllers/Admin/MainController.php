<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\MainRequest;
use App\Models\Menu;

class MainController extends Controller
{
    //        
    public function index() {        
        $maxid=Menu::max('id');
        $menus = Menu::orderBy('sort')->get();
        return view('admin.menu.index', compact('menus','maxid'));         
    }
    
    public function store(MainRequest $request) {
        
        $i=1;
        if( is_array($request['image_delete'])){            
            foreach ($request['image_delete'] as $value) {                
                Menu::destroy($value);
            }
        }        
        if( is_array($request['menu'])){
            foreach ($request['menu'] as $value) {                
                $value['sort'] = $i++;
                if (isset($value['id'])){
                    Menu::where('id','=',$value['id'])->update($value);
                }
                else{                    
                    Menu::create($value);
                }
            }
        }
        return back()->with('success', 'Меню сохранено');
    }
}
