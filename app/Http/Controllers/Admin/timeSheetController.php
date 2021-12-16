<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Requests\Admin\timeSheetRequest;
/*use App\Http\Requests\Admin\offHoursChangeRequest;
use App\Http\Requests\Admin\offHoursTableRequest;
use App\Http\Requests\Admin\offHoursPersRequest;
use App\Http\Requests\Admin\offHoursDelPersRequest;*/
use Illuminate\Support\Facades\Auth;
use App\Models\off_hours;
use App\Models\User;
use SimpleXMLElement;

use Symfony\Component\HttpFoundation\Request;

class timeSheetController extends Controller
{
    public function download( $date = 1)
    {
      if($date==1){
        $date=date('Y-m-d');
      }
        $users=User::orderBy('department')->orderBy('name')->get();

        return view('admin.timeSheet.download', compact('users','date'));
    }

    /*public function storepers(offHoursPersRequest $request)
    {

      foreach ($request['pers'] as $key => $value){

        $date['user_id'] = $value;
        $date['date']=Carbon::createFromFormat('Y-m-d', $request['date'])->startOfDay();


        $users=User::Where('id','=',$date['user_id'])->get();
        $date['prpsk'] = $users[0]['pager'];
        $date['room'] = $users[0]['physicalDeliveryOfficeName'];
        $date['phone'] = $users[0]['telephoneNumber'];
        off_hours::Where('user_id','=',$date['user_id'])->Where('date','=',$date['date'])->delete();
        off_hours::Create($date);
      }

      return back()->with('success', 'Записи добавлена');
    }

    public function change(offHoursChangeRequest $request)
    {
        $date['prpsk'] = $request['prpsk'];
        $date['room'] = $request['room'];
        $date['phone'] = $request['phone'];
        off_hours::Where('id','=',$request['id'])->update($date);

        return back()->with('success', 'Данные изменены');
    }

    public function delPers(offHoursDelPersRequest $request){
      $date['date'] = $request['date'];
      $date['user_id'] = $request['user_id'];
      off_hours::Where('user_id','=',$date['user_id'])->Where('date','=',$date['date'])->delete();
      return back()->with('success', 'Запись удалена');
    }

    public function offHoursTable(offHoursTableRequest $request)
    {
        $date = $request['date'];
        $thing = $request['thing'];
	      $staff_id = $request['staff_id'];
        $staff=User::Where('id', "=", $staff_id)->get();
        $users=User::orderBy('department')->orderBy('name')->get();
        if(Carbon::createFromFormat('Y-m-d', $date)->isWeekend()){
          $merges = ["6", "23", "16", "16", "16", "16", "16"];//Кол-во ячеек в столбце
          $style = [
              "m375228552",
              "m375228572",
              "m375228592",
              "m375228592",
              "m375228612",
              "m375228632",
              "m375228652" //стили столбцов
              ];
          $text=["№ п/п","Фамилия И.О.","№ пропуска","№ помещения","Телефон","Время входа","Время выхода"];
          $week=1;
        }else{
          $merges = ["6", "40", "16", "16", "16", "16"];//Кол-во ячеек в столбце
          $style = [
              "m375228552",
              "m375228572",
              "m375228592",
              "m375228612",
              "m375228632",
              "m375228652" //стили столбцов
              ];
          $text=["№ п/п","Фамилия И.О.","№ пропуска","№ помещения","Телефон","Время выхода"];
          $week=0;
        }

        $sxe = new SimpleXMLElement('OffHoursTemplNew.xml', NULL, TRUE);//создание файла

        $allchild = $sxe->children();
        $allchild->Worksheet->Table->Row[5]->Cell[78]->Data = 'тел.'.$staff[0]->mobile;
        $allchild->Worksheet->Table->Row[9]->Cell[11]->Data = $date;
        $allchild->Worksheet->Table->Row[10]->Cell[1]->Data = $thing;
        if(Carbon::createFromFormat('Y-m-d', $date)->isWeekend()){
          $allchild->Worksheet->Table->Row[9]->Cell[10]->Data = 'Прошу Вас разрешить работы после 8.00  до  23.00';
        }
        $newrow = $allchild->Worksheet->Table->addChild('Row');
        $newrow->addAttribute('xmlns:ss:Height','27');
        for( $i=0; $i < 6+$week; $i++ ) {
            $cell = $newrow->addChild('Cell');
            $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
            $cell->addAttribute('xmlns:ss:StyleID','m375223640' );
            $data = $cell->addChild('Data',$text[$i]);
            $data->addAttribute('xmlns:ss:Type',"String" );
        }


        $idx = 0;
        foreach ($users as $user){
            if (count ($user->offHoursDate($date))){
                $offhours=$user->offHoursDate($date);
                $names = 0;
                $idx++;
                foreach ($offhours as $num => $offhour){
                    $newrow = $sxe->Worksheet->Table->addChild('Row');
                    for( $i=0; $i < 6+$week; $i++ ) {
                        $cell = $newrow->addChild('Cell');
                        $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
                        $cell->addAttribute('xmlns:ss:StyleID',$style[$i] );
                        $data = $cell->addChild('Data');
                        $data->addAttribute('xmlns:ss:Type',"String" );
                    }
                    $cells = $newrow->children();
                    if ($names == 0){
                        $names=1;
                        $cells[0]->Data = $idx;
                        $cells[1]->Data = $user->shortName();
                    }
                    if ($offhour->prpsk){
                        $cells[2]->Data = $offhour->prpsk;
                    }
                    if ($offhour->room){
                        $cells[3]->Data = $offhour->room;
                    }
                    if ($offhour->phone){
                        $cells[4]->Data = $offhour->phone;
                    }

                }
            }
        }

      for (;$idx < 23; $idx++) {
	    $newrow = $sxe->Worksheet->Table->addChild('Row');
                    for( $i=0; $i < 6+$week; $i++ ) {
                        $cell = $newrow->addChild('Cell');
                        $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
                        $cell->addAttribute('xmlns:ss:StyleID',$style[$i] );
                        $data = $cell->addChild('Data');
                        $data->addAttribute('xmlns:ss:Type',"String" );
                    }
           $cells = $newrow->children();
           $cells[0]->Data = $idx;

        }

        // Конец
        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"115" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','18' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s65" );
        $cell1->addChild('Data',"Старший")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','22' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s78" );
        $cell1->addChild('Data',$staff[0]->shortName())->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s78" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','30' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s119" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','20' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s78" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','18' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','22' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );
        $cell1->addChild('Data',"(ФИО)")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s78" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','30' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s78" );
        $cell1->addChild('Data',"(подпись старшего)")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','20' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"115" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','9' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','105' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s83" );
        $cell1->addChild('Data',"Несу персональную ответственность за соблюдение мер противопожарной безопасности и")->addAttribute('xmlns:ss:Type',"String" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','24' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );
        $cell1->addChild('Data',"техники безопасности")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','49' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s119" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','40' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','25' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','89' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s79" );
        $cell1->addChild('Data',"(подпись начальника подразделения)")->addAttribute('xmlns:ss:Type',"String" );

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"115" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','31' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );
        $cell1->addChild('Data',"Начальник НИЦ-1")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','43' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','39' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s121" );
        $cell1->addChild('Data',"В.А. Нечаев")->addAttribute('xmlns:ss:Type',"String" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $endrow->addAttribute('xmlns:ss:Height','26');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','115' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s125" );
        $cell1->addChild('Data',"Разрешено дополнение списка с заверением личной подписью Е.Н. Козлова, В.И. Лещинского, М.В. Козлова, С.В. Пластининой, М.О. Костишина, Н.Г. Денисовой")->addAttribute('xmlns:ss:Type',"String" );



        $sxe->asXML('Table'.$date.'.xml');

        return response()->download('Table'.$date.'.xml');
    }*/
}
