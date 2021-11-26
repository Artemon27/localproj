<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Requests\Admin\CreateKeyRequest;
use App\Http\Requests\Admin\CreateKeyTableRequest;
use App\Http\Requests\Admin\CreateKeyPersRequest;
use App\Http\Requests\Admin\CreateKeyDelPersRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Rooms;
use App\Models\RoomPersons;
use App\Models\User;
use SimpleXMLElement;

use Symfony\Component\HttpFoundation\Request;

class CreateKeyController extends Controller
{

    public function store(CreateKeyRequest $request)
    {
        if(isset($request['imp']))  $date['imp'] = 1;
        $date['otdel'] = $request['otdel'];
        $date['penal'] = $request['penal'];
        $date['corpus_room'] = $request['corpus_room'];
        $date['phone'] = $request['phone'];

        Rooms::Where('penal','=',$date['penal'])->delete();
        Rooms::Create($date);

        return back()->with('success', 'Комната добавлена');
    }

    public function storepers(CreateKeyPersRequest $request)
    {
      $date['user_id'] = $request['pers'];
      $date['room_id'] = $request['room'];

      RoomPersons::Where('user_id','=',$date['user_id'])->Where('room_id','=',$date['room_id'])->delete();
      RoomPersons::Create($date);

      return back()->with('success', 'Запись добавлена');
    }

    public function delpers(CreateKeyDelPersRequest $request)
    {
      $date['user_id'] = $request['user_id'];
      $date['room_id'] = $request['room_id'];

      RoomPersons::Where('user_id','=',$date['user_id'])->Where('room_id','=',$date['room_id'])->delete();

      return back()->with('success', 'Запись удалена');
    }


    public function download( $data = -1)
    {
      $a=$data;
      $users=User::orderBy('department')->orderBy('name')->get();
      $rooms=Rooms::orderBy('otdel')->get(); $staff=0;
      if($data != -1){
        $data=Rooms::Where('id','=',$a)->get();
        $staff=RoomPersons::Where('room_id','=',$a)->get();
      }
      return view('admin.createkey.download', compact('users','rooms', 'data','staff'));

    }


    public function CreateKeyTable(CreateKeyTableRequest $request)
    {

        $data = $request['room_id'];

        $room_pers=RoomPersons::Where('room_id','=',$data)->get();
        $room=Rooms::Where('id','=',$data)->get();

        $merges = ["11", "11", "23", "9", "33", "9", "9", "22", "16"];//Кол-во ячеек в столбце
        $style = 'm377539832';


        $sxe = new SimpleXMLElement('CreateKeyTempl.xml', NULL, TRUE);//создание файла

        $allchild = $sxe->children();
        $allchild->Worksheet->Table->Row[0]->Cell[10]->Data = '';
        if(isset($room[0]->imp)){
          $allchild->Worksheet->Table->Row[0]->Cell[10]->Data = 'Генеральному директору';
          $allchild->Worksheet->Table->Row[1]->Cell[10]->Data = 'А.В. Гурьянову';
        }


        foreach ($room_pers as $id => $pers){

                $newrow = $sxe->Worksheet->Table->addChild('Row');
                for( $i=0; $i < 9; $i++ ) {
                    $cell = $newrow->addChild('Cell');
                    $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
                    $cell->addAttribute('xmlns:ss:StyleID',$style );
                    $data = $cell->addChild('Data');
                    $data->addAttribute('xmlns:ss:Type',"String" );
                }
                $cells = $newrow->children();
                if($id == 0){
                  $cells[0]->Data = $room[0]->otdel;
                  $cells[1]->Data = $room[0]->penal;
                  $cells[2]->Data = $room[0]->corpus_room;
                  $cells[3]->Data = $room[0]->phone;
                }
                $staff = User::Where('id','=',$pers->user_id)->get();
                $cells[4]->Data = $staff[0]->name." ".$staff[0]->title;
                $cells[5]->Data = $staff[0]->pager;

        }

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"145" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s97" );
        $cell1->addChild('Data','Начальник НИЦ-1')->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','50' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','30' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s97" );
        $cell1->addChild('Data','В.А. Нечаев')->addAttribute('xmlns:ss:Type',"String" );

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"145" );
        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"145" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s101" );
        $cell1->addChild('Data','М.О. Костишин')->addAttribute('xmlns:ss:Type',"String" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s101" );
        $cell1->addChild('Data','М.тел 26-44')->addAttribute('xmlns:ss:Type',"String" );

        $sxe->asXML('Table.xml');

        return response()->download('Table.xml');
    }
}
