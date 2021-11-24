<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\timeSheetRequest;
use App\Models\time_sheet;

use App\Models\User;
use SimpleXMLElement;


class timeSheetController extends Controller
{


    public function index() {
        $id = Auth::user()->id;
        
        $now = Carbon::now();
        $numdays = 0;
        $times= time_sheet::Where('user_id','=',$id)->get();

        return view('timeSheet.index', compact('times','numdays'));
    }

    public function store(timeSheetRequest $request) //отправка в БД
    {
      if(isset($request['time'])){
        $id = Auth::user()->id;
        $now = Carbon::now();
        if($request['month'] == 12){
          $a=1;
          $b=$request['year']+1;
        }else{
          $a = $request['month']+1;
          $b=$request['year'];
        }
        $datefrom = $request['year']."-".$request['month']."-1 00:00:00";
        $dateto = $b."-".$a."-1 00:00:00";
        time_sheet::Where('user_id','=',$id)->Where('date','>=',$datefrom)->Where('date','<',$dateto)->delete();

        if (isset($request['time'][$request['year']][$request['month']])){
                foreach ($request['time'][$request['year']][$request['month']] as $key => $date){
                $date1['user_id'] = $id;
                $date1['date']=$request['year']."-".$request['month']."-".$key;
                $date1['time']=$date;
                time_sheet::Create($date1);
            }
        }

        return back()->with('success', 'Данные сохранены');
      }else{
        $months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
        $staff = array('НИО-15' => 'Козвлов М.В.','НИО-16' => 'Пластинина С.В.','НИО-17' => 'Костишин М.О.');
        $id = Auth::user()->id;
        if($request['month'] == 12){
          $a=1;
          $b=$request['year']+1;
        }else{
          $a = $request['month']+1;
          $b=$request['year'];
        }
        $datefrom = $request['year']."-".$request['month']."-1 00:00:00";
        $dateto = $b."-".$a."-1 00:00:00";

        $times = time_sheet::Where('user_id','=',$id)->Where('date','>=',$datefrom)->Where('date','<',$dateto)->get();
        $users=User::Where('id','=',$id)->get();
        $user = $users[0]->shortName();
        $dep = $users[0]->department;
        $sxe = new SimpleXMLElement('timeSheetTemplNew.xml', NULL, TRUE);//создание файла

        $allchild = $sxe->children();

        $allchild->Worksheet->Table->Row[9]->Cell[0]->Data = $user;
        $allchild->Worksheet->Table->Row[7]->Cell[1]->Data = $months[$request['month']]." ".$request['year'];
        $allchild->Worksheet->Table->Row[10]->Cell[20]->Data = 'Начальник '.$dep;
        $allchild->Worksheet->Table->Row[10]->Cell[62]->Data = $staff[$dep];
        $sum = 0;
        if (count ($times)){
          for ($i=0; $i < count ($times); $i++) {
            $allchild->Worksheet->Table->Row[8]->Cell[$i]->Data = $i+1;
            $allchild->Worksheet->Table->Row[9]->Cell[$i+1]->Data = $times[$i]['time'];
            $sum+=$times[$i]['time'];
          }
        }
        $allchild->Worksheet->Table->Row[9]->Cell[32]->Data = $sum;
        $sxe->asXML('Table.xml');
        return response()->download('Table.xml');
      }
    }

}
