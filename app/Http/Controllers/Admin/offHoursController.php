<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Requests\Admin\offHoursRequest;
use App\Http\Requests\Admin\offHoursTableRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\off_hours;
use App\Models\User;
use SimpleXMLElement;

use Symfony\Component\HttpFoundation\Request;

class offHoursController extends Controller
{
        public function store(offHoursRequest $request)
    {
        $id = $request['id'];

        $now = Carbon::now();

        off_hours::Where('user_id','=',$id)->delete();

        if (isset($request['data'])){
                foreach ($request['data'] as $date){
                $date['user_id'] = $id;
                $date['datefrom']=Carbon::createFromFormat('Y-m-d', $date['datefrom'])->startOfDay();
                $date['dateto']=$date['datefrom']->copy()->addDays($date['days']-1)->endOfDay();
                off_hours::Create($date);
            }
        }
        return back()->with('success', 'Отпуск обновлён');
    }

    public function download( $date = 1)
    {
      if($date==1){
        $date=date('Y-m-d');
      }
        $users=User::orderBy('department')->orderBy('name')->get();

        return view('admin.offhours.download', compact('users','date'));
    }


    public function offHoursTable(offHoursTableRequest $request)
    {

        $date = $request['date'];
        $thing = $request['thing'];
        if($request['staff'] != 'other'){
          $staff = $request['staff'];
        }
        else{
          $staff = $request['other_val'];
        }

        $users=User::orderBy('department')->orderBy('name')->get();

        $merges = ["6", "40", "16", "16", "16", "16"];//Кол-во ячеек в столбце
        $style = [
            "m240598220",
            "m240598240",
            "m240598260",
            "m240598280",
            "m240598300",
            "m240598952" //стили столбцов
            ];


        $sxe = new SimpleXMLElement('OffHoursTemplNew.xml', NULL, TRUE);//создание файла

        $allchild = $sxe->children();

        $allchild->Worksheet->Table->Row[9]->Cell[7]->Data = $date;
        $allchild->Worksheet->Table->Row[10]->Cell[1]->Data = $thing;
        foreach ($users as $user){
            if (count ($user->offHoursDate($date))){
                $offhours=$user->offHoursDate($date);
                $names = 0; $n=0;
                foreach ($offhours as $num => $offhour){
                  $n++;
                    $newrow = $sxe->Worksheet->Table->addChild('Row');
                    for( $i=0; $i < 6; $i++ ) {
                        $cell = $newrow->addChild('Cell');
                        $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
                        $cell->addAttribute('xmlns:ss:StyleID',$style[$i] );
                        $data = $cell->addChild('Data');
                        $data->addAttribute('xmlns:ss:Type',"String" );
                        $print = $cell->addChild('NamedCell');
                        $print->addAttribute('xmlns:ss:Name',"Print_Area" );
                    }
                    $cells = $newrow->children();
                    if ($names == 0){
                        $names=1;
                        $cells[0]->Data = $n;
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


        // Конец
        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"115" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','18' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s64" );
        $cell1->addChild('Data',"Старший")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','22' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s75" );
        $cell1->addChild('Data',$staff)->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s75" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','30' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s114" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','20' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s75" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','18' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );


        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','22' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );
        $cell1->addChild('Data',"(ФИО)")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s75" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','30' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s75" );
        $cell1->addChild('Data',"(подпись старшего)")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','20' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"115" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','9' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','105' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s79" );
        $cell1->addChild('Data',"Несу персональную ответственность за соблюдение мер противопожарной безопасности и техники")->addAttribute('xmlns:ss:Type',"String" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','13' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );
        $cell1->addChild('Data',"безопасности")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','60' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s108" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','40' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','25' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','37' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );
        $cell1->addChild('Data',"(подпись начальника подразделения)")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','51' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s75" );

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"115" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','31' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );
        $cell1->addChild('Data',"Начальник НИЦ-1")->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','43' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','39' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s76" );
        $cell1->addChild('Data',"В.А. Нечаев")->addAttribute('xmlns:ss:Type',"String" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $endrow->addAttribute('xmlns:ss:Height','23');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','115' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s110" );
        $cell1->addChild('Data',"Разрешено дополнение списка с заверением личной подписью Е.Н. Козлова, В.И. Лещинского, М.В. Козлова, С.В. Пластининой, М.О. Костишина, Н.Г. Денисовой")->addAttribute('xmlns:ss:Type',"String" );



        $sxe->asXML('Table'.$date.'.xml');

        return response()->download('Table'.$date.'.xml');
    }
}
