<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Requests\Admin\timeSheetRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\time_sheet;
use App\Models\User;
use App\Models\Setting;
use SimpleXMLElement;

use Symfony\Component\HttpFoundation\Request;

class timeSheetController extends Controller
{
    public function timeSheetpers(User $user = NULL)
    {
          if ($user==NULL){
              $user = Auth::User();
          }
          $id = 1;
          $setting = new Setting;
          $year = $setting->CentralYear();

          $times= time_sheet::Where('user_id','=',$user->id)->get();
          $users= User::get();

        return view('admin.timeSheet.index', compact('times','user','users','year'));
    }

    public function chose(timeSheetRequest $request)
    {
        $user = User::find($request['id']);
        return redirect()->route('admin.timeSheet.timeSheetpers', ['user' => $user]);
    }

    public function store(timeSheetRequest $request) //отправка в БД
    {
      if(isset($request['time'])){
        $id = $request['id'];
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

                $date1['time']=(float) str_replace(',','.',$date);
                time_sheet::Create($date1);
            }
        }

        return back()->with('success', 'Данные сохранены');
      }else{
        $months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
        $staff = array('НИО-15' => 'Козвлов М.В.','НИО-16' => 'Пластинина С.В.','НИО-17' => 'Костишин М.О.');
        $id = $request['id'];
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
