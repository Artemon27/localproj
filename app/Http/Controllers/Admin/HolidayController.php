<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Requests\Admin\HolidayRequest;
use App\Http\Requests\Admin\holiTableRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Holiday;
use App\Models\User;
use SimpleXMLElement;

use Symfony\Component\HttpFoundation\Request;

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
        $id = $request['id'];
        
        $now = Carbon::now();
        
        Holiday::Where('user_id','=',$id)->delete();
        
        if (isset($request['data'])){
                foreach ($request['data'] as $date){
                $date['user_id'] = $id;
                $date['datefrom']=Carbon::createFromFormat('Y-m-d', $date['datefrom'])->startOfDay();
                $date['dateto']=$date['datefrom']->copy()->addDays($date['days']-1)->endOfDay();
                Holiday::Create($date);
            }
        }
        return back()->with('success', 'Отпуск обновлён');
    }                
    
    public function holiday(User $user = NULL) {        
        if ($user==NULL){
            $user = Auth::User();
        }
        $id = 1;
        
        $dates= Holiday::Where('user_id','=',$user->id)->get();
        $users= User::get();
        
        $numdays = 0;
        
        foreach ($dates as $date){
            $date->datefromStr = strtotime($date->datefrom);
            $date->datetoStr = strtotime($date->dateto);
            $numdays = $numdays+$date->days;
        }
        return view('admin.holiday.index', compact('dates','numdays','user','users'));         
    }
    
    public function chose(Request $request)
    {                             
        $user = User::find($request['id']);
        return redirect()->route('admin.holidays.holiday', ['user' => $user]);
    }
    
    public function download( $year = 2022)
    {        
        $users=User::orderBy('department')->orderBy('name')->get();
                     
        return view('admin.holidays.download', compact('users','year'));    
    }
    
    
    public function holiTable(holiTableRequest $request)
    {        
        $year = $request['year'];

        $users=User::orderBy('department')->orderBy('name')->get();
        
        $merges = ["25", "29", "12", "19", "11", "10", "12", "13", "13", "13" ];
        $style = [
            "s165", 
            "s165", 
            "m2429262496776", 
            "m2429262496796", 
            "m2429262496816", 
            "m2429262496836", 
            "m2429262489872", 
            "m2429262489892", 
            "m2429262489912", 
            "m2429262489932" 
            ];
        
        
        $sxe = new SimpleXMLElement('HoliTemplnew.xml', NULL, TRUE);
        
        $allchild = $sxe->children();
        $department='n';
        foreach ($users as $user){            
            if (count ($user->holidaysYear($year))){
                if ($department != $user->department)
                {
                    $newrow = $allchild->Worksheet->Table->addChild('Row');                    
                    for( $i=0; $i < 10; $i++ ) {
                        $cell = $newrow->addChild('Cell');
                        $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
                        $cell->addAttribute('xmlns:ss:StyleID','m2429262496736' );
                        $data = $cell->addChild('Data');
                        $data->addAttribute('xmlns:ss:Type',"String" );
                    }                
                    $cells = $newrow->children();
                    $cells[0]->Data = $user->department;
                    $department = $user->department;
                }
                $holidays=$user->holidaysYear($year);
                $names = 0;
                foreach ($holidays as $num => $holiday){                    
                    $newrow = $allchild->Worksheet->Table->addChild('Row');                    
                    for( $i=0; $i < 10; $i++ ) {
                        $cell = $newrow->addChild('Cell');
                        $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
                        $cell->addAttribute('xmlns:ss:StyleID',$style[$i] );
                        $data = $cell->addChild('Data');
                        $data->addAttribute('xmlns:ss:Type',"String" );
                    }                
                    $cells = $newrow->children();
                    if ($names == 0){
                        $names=1;
                        $cells[0]->Data = $user->title;
                        $cells[1]->Data = $user->shortName();
                        $cells[2]->Data = $user->pager;
                    }                    
                    $cells[3]->Data = $holiday->days;                
                    if ($holiday->PVT){
                        $cells[4]->Data = $holiday->PVT.'ПВТ';
                    }     
                    if ($holiday->INV){
                        if ($cells[4]->Data>0){
                            $cells[4]->Data = $cells[4]->Data.'+';    
                        }
                        $cells[4]->Data = $cells[4]->Data.$holiday->INV.'ИНВ';                  
                    }     
                    if ($holiday->OB){
                        if ($cells[4]->Data>0){
                            $cells[4]->Data = $cells[4]->Data.'+';    
                        }
                        $cells[4]->Data = $cells[4]->Data.$holiday->OB.'ОБ';
                    }     
                    $cells[5]->Data = date("d.m.y", strtotime($holiday->datefrom));
                }                
            }
        }
        


        // Конец
        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"166" );   
                
        $endrow = $allchild->Worksheet->Table->addChild('Row');   
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:StyleID',"s164" );
        $cell1->addChild('Data',"Руководитель кадровой службы")->addAttribute('xmlns:ss:Type',"String" );
        
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:Index',"34" );
        $cell1->addAttribute('xmlns:ss:MergeAcross',"53" );
        
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:Index',"92" );
        $cell1->addAttribute('xmlns:ss:MergeAcross',"22" );
        
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:Index',"119" );
        $cell1->addAttribute('xmlns:ss:MergeAcross',"48" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');   
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:Index',"34" );
        $cell1->addAttribute('xmlns:ss:MergeAcross',"53" );
        $cell1->addAttribute('xmlns:ss:StyleID',"s90" );
        $cell1->addChild('Data',"(должность)")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:Index',"92" );
        $cell1->addAttribute('xmlns:ss:MergeAcross',"22" );
        $cell1->addAttribute('xmlns:ss:StyleID',"s90" );
        $cell1->addChild('Data',"(личная подпись)")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:Index',"119" );
        $cell1->addAttribute('xmlns:ss:MergeAcross',"48" );
        $cell1->addAttribute('xmlns:ss:StyleID',"s90" );
        $cell1->addChild('Data',"(расшифровка подписи)")->addAttribute('xmlns:ss:Type',"String" );        
           
        
        $sxe->asXML('Table'.$year.'.xml');

        return response()->download('Table'.$year.'.xml');
    }
}
