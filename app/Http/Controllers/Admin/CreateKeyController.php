<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Requests\Admin\CreateKeyRequest;
use App\Http\Requests\Admin\CreateKeyTableRequest;
use App\Http\Requests\Admin\CreateKeyDeleteRoomRequest;
use App\Http\Requests\Admin\CreateKeyPersRequest;
use App\Http\Requests\Admin\CreateKeyDelPersRequest;
use App\Http\Controllers\Admin\Traits\ToggleTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Rooms;
use App\Models\RoomPersons;
use App\Models\User;
use SimpleXMLElement;

use Symfony\Component\HttpFoundation\Request;

class CreateKeyController extends Controller
{
    use ToggleTrait;
    
    protected $modelName = RoomPersons::class;
    
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
      foreach ($request['pers'] as $key => $value){

        $date['user_id'] = $value;
        $date['room_id'] = $request['room'];

        RoomPersons::Where('user_id','=',$date['user_id'])->Where('room_id','=',$date['room_id'])->delete();
        RoomPersons::Create($date);
      }

      return back()->with('success', 'Записи добавлена');
    }
    public function deleteRoom(CreateKeyDeleteRoomRequest $request){
      $date['room_id'] = $request['room_id'];
      Rooms::Where('id','=',$date['room_id'])->delete();
      return back()->with('success', 'Комната удалена');
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
        if($request['staff'] != 'other'){
          $staff_ = $request['staff'];
          $staff_=User::Where('name','=',$staff_)->get();
        }else{
          $staff_ = $request['other_val'];
        }
        $room_pers=RoomPersons::Where('room_id','=',$data)->orderByDesc('main')->get();
        $room=Rooms::Where('id','=',$data)->get();

        $merges = ["11", "11", "23", "9", "41", "9", "9", "22", "16"];//Кол-во ячеек в столбце
        $merges_user = ["41", "9", "9", "22", "16"];//Кол-во ячеек в столбце
        $style = 'm407577648';


        $sxe = new SimpleXMLElement('CreateKeyTempl.xml', NULL, TRUE);//создание файла

        $allchild = $sxe->children();
        $allchild->Worksheet->Table->Row[1]->Cell[10]->Data = '';
        if(isset($room[0]->imp)){
          $allchild->Worksheet->Table->Row[0]->Cell[10]->Data = 'СОГЛАСОВАНО';
          $allchild->Worksheet->Table->Row[1]->Cell[10]->Data = 'Генеральный директор';
          $allchild->Worksheet->Table->Row[2]->Cell[10]->Data = 'А.В. Гурьянов';
        }


        foreach ($room_pers as $id => $pers){

                $newrow = $sxe->Worksheet->Table->addChild('Row');
                 $newrow->addAttribute('xmlns:ss:AutoFitHeight','0' );
                 $newrow->addAttribute('xmlns:ss:Height','25' );
                $cells = $newrow->children();
                if($id == 0){
                  for( $i=0; $i < 9; $i++ ) {
                      $cell = $newrow->addChild('Cell');
                      if($i<4){
                        $cell->addAttribute('xmlns:ss:MergeDown',count($room_pers)-1);
                      }
                      $cell->addAttribute('xmlns:ss:MergeAcross',$merges[$i] );
                      $cell->addAttribute('xmlns:ss:StyleID',$style );
                      $data = $cell->addChild('Data');
                      $data->addAttribute('xmlns:ss:Type',"String" );
                  }
                  $cells[0]->Data = $room[0]->otdel;
                  $cells[1]->Data = $room[0]->penal;
                  $cells[2]->Data = $room[0]->corpus_room;
                  $cells[3]->Data = $room[0]->phone;
                  $staff = User::Where('id','=',$pers->user_id)->get();
                  $cells[4]->Data = $staff[0]->name."&#10;".$staff[0]->title;
                  $cells[5]->Data = $staff[0]->pager;
                  $cells[6]->Data = $staff[0]->pechat;
                  $cells[7]->Data = $staff[0]->mobile;
                } else {
                  for( $i=0; $i < 5; $i++ ) {
                      $cell = $newrow->addChild('Cell');
                      if ( $i == 0 ) {
                        $cell->addAttribute('xmlns:ss:Index',"59" );
                      }
                      $cell->addAttribute('xmlns:ss:MergeAcross',$merges_user[$i] );
                      $cell->addAttribute('xmlns:ss:StyleID',$style );
                      $data = $cell->addChild('Data');
                      $data->addAttribute('xmlns:ss:Type',"String" );
                  }
                  $staff = User::Where('id','=',$pers->user_id)->get();
                  $cells[0]->Data = $staff[0]->name."&#10;".$staff[0]->title;
                  $cells[1]->Data = $staff[0]->pager;
                  $cells[2]->Data = $staff[0]->pechat;
                  $cells[3]->Data = $staff[0]->mobile;
                }
        }

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"145" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s98" );
        $cell1->addChild('Data','Начальник НИЦ-1')->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','50' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','30' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s98" );
        $cell1->addChild('Data','В.А. Нечаев')->addAttribute('xmlns:ss:Type',"String" );

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"145" );
        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"145" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s100" );
        if(isset($staff_[0]->name)){
          $cell1->addChild('Data',$staff_[0]->shortName())->addAttribute('xmlns:ss:Type',"String" );
        }else{
          $cell1->addChild('Data',$staff_)->addAttribute('xmlns:ss:Type',"String" );
        }


        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s100" );
        if(isset($staff_[0]->telephoneNumber)){
          $cell1->addChild('Data','м.тел '.$staff_[0]->telephoneNumber)->addAttribute('xmlns:ss:Type',"String" );
        }

        $sxe->asXML('Table.xml');

        return response()->download('Table.xml');
    }
}
