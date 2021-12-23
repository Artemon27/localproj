<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Http\Requests\Admin\CreateKeyRequest;
use App\Http\Requests\Admin\CreateKeyTableRequest;
use App\Http\Requests\Admin\CreateKeyChangeRequest;
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

if(Rooms::Where('id_corp','=',$request['id_corp'])->where('id_room','=',$request['id_room'])->count() == 0 ) {
          if(isset($request['imp']))  $date['imp'] = 1;
          $date['otdel'] = $request['otdel'];
          $date['penal'] = $request['penal'];
          $date['id_corp'] = $request['id_corp'];
          $date['id_room'] = $request['id_room'];
          $date['corpus_room'] = 1;
          $date['phone'] = $request['phone'];
          Rooms::Create($date);
          return back()->with('success', 'Комната добавлена');
        } else {
          return back()->with('warning', 'Комната уже добавлена');
        }
    }
    public function changepers(CreateKeyChangeRequest $request)
    {
      $date['name_staff'] = $request['name_staff'];
      $date['name_post'] = $request['name_post'];
      $date['pager'] = $request['pager'];
      $date['pechat'] = $request['pechat'];
      $date['mobile'] = $request['mobile'];
      RoomPersons::Where('room_id','=',$request['room_id'])->Where('user_id','=',$request['user_id'])->update($date);
      return back()->with('success', 'Записи добавлена');
    }

    public function change(CreateKeyRequest $request)
    {
        if(isset($request['imp'])){
          $date['imp'] = 1;
        }else{
          $date['imp'] = null;
        }
        $date['otdel'] = $request['otdel'];
        $date['penal'] = $request['penal'];
        $date['id_corp'] = $request['id_corp'];
        $date['id_room'] = $request['id_room'];
        $date['corpus_room'] = 1;
        $date['phone'] = $request['phone'];
        Rooms::Where('id','=',$request['id'])->update($date);

        return back()->with('success', 'Данные комнаты изменены');
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


    public function download($data = -1)
    {
        $a=$data;
        $users=User::orderBy('department')->orderBy('name')->get();
        $rooms=Rooms::orderBy('otdel')->get();
        $staff=0;
        if($data != -1){
          $data=Rooms::Where('id','=',$a)->get();
          $staff=RoomPersons::Where('room_id','=',$a)->get();
        }
        return view('admin.createkey.download', compact('users','rooms', 'data','staff'));
    }

    public function search(CreateKeyChangeRequest $request){
      $users=User::orderBy('department')->orderBy('name')->get();
      $rooms=Rooms::orderBy('otdel')->orWhere('otdel','LIKE',"%".$request['srch']."%")->orWhere('penal','LIKE',"%".$request['srch']."%")->orWhere('id_corp','LIKE',"%".$request['srch']."%")->orWhere('id_room','LIKE',"%".$request['srch']."%")->orWhere('phone','LIKE',"%".$request['srch']."%")->get();
      $data = -1;
      $staff=0;
      return view('admin.createkey.download', compact('users','rooms', 'data','staff'));
    }


    public function CreateKeyTable(CreateKeyTableRequest $request)
    {

        $data = $request['room_id'];
        $staff_=User::Where('id','=',$request['staff'])->get();
        $room_pers=RoomPersons::Where('room_id','=',$data)->orderByDesc('main')->get();
        $room=Rooms::Where('id','=',$data)->get();

        $merges = ["11", "11", "16", "9", "41", "9", "9", "22", "16"];//Кол-во ячеек в столбце
        $merges_user = ["41", "9", "9", "22", "16"];//Кол-во ячеек в столбце
        $style = 'm384756732';


        $sxe = new SimpleXMLElement('CreateKeyTempl.xml', NULL, TRUE);//создание файла

        $allchild = $sxe->children();
        $allchild->Worksheet->Table->Row[1]->Cell[10]->Data = '';
        $y=(int)date('Y')+1;
        if(isset($room[0]->imp)){
          $allchild->Worksheet->Table->Row[0]->Cell[10]->Data = 'СОГЛАСОВАНО';
          $allchild->Worksheet->Table->Row[1]->Cell[10]->Data = 'Генеральный директор';
          $allchild->Worksheet->Table->Row[2]->Cell[11]->Data = 'А.В. Гурьянов';
          $allchild->Worksheet->Table->Row[4]->Cell[0]->Data = 'Список сотрудников НИЦ-1, имеющих право на вскрытие и получение пеналов от режимного помешения, на '.$y.' г.';
        } else {
          $allchild->Worksheet->Table->Row[4]->Cell[0]->Data = 'Список сотрудников НИЦ-1, имеющих право на вскрытие и получение пеналов на '.$y.' г.';
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
                  //$cells[2]->Data = $room[0]->corpus_room;
                  $cells[2]->Data = "Корпус ".$room[0]->id_corp."\rПомещение ".$room[0]->id_room;
                  $cells[3]->Data = $room[0]->phone;
                  $staff = User::Where('id','=',$pers->user_id)->get();
                  $cells[4]->Data = $staff[0]->name."\r".$staff[0]->title;
                  $cells[5]->Data = $staff[0]->pager;
                  $cells[6]->Data = $staff[0]->pechat;
                  $cells[7]->Data = $staff[0]->mobile;
                } else {

                  for( $i=0; $i < 5; $i++ ) {
                      $cell = $newrow->addChild('Cell');
                      if ( $i == 0 ) {
                        $cell->addAttribute('xmlns:ss:Index',"52" );
                      }
                      $cell->addAttribute('xmlns:ss:MergeAcross',$merges_user[$i] );
                      $cell->addAttribute('xmlns:ss:StyleID',$style );
                      $data = $cell->addChild('Data');
                      $data->addAttribute('xmlns:ss:Type',"String" );
                  }
                  if($pers->name_post != null){
                      $cells[0]->Data = $pers->name_staff."\r".$pers->name_post;
                      $cells[1]->Data = $pers->pager;
                      $cells[2]->Data = $pers->pechat;
                      $cells[3]->Data = $pers->mobile;
                    }else{
                      $staff = User::Where('id','=',$pers->user_id)->get();
                      $cells[0]->Data = $staff[0]->name."\r".$staff[0]->title;
                      $cells[1]->Data = $staff[0]->pager;
                      $cells[2]->Data = $staff[0]->pechat;
                      $cells[3]->Data = $staff[0]->mobile;
                  }
                }
        }

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"138" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s107" );
        $cell1->addChild('Data','Начальник НИЦ-1')->addAttribute('xmlns:ss:Type',"String" );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','50' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','30' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s107" );
        $cell1->addChild('Data','В.А. Нечаев')->addAttribute('xmlns:ss:Type',"String" );

        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"138" );
        $allchild->Worksheet->Table->addChild('Row')->addChild('Cell')->addAttribute('xmlns:ss:MergeAcross',"138" );

        $endrow = $allchild->Worksheet->Table->addChild('Row');
        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','11' );

        $cell1 = $endrow->addChild('Cell');
        $cell1->addAttribute('xmlns:ss:MergeAcross','21' );
        $cell1->addAttribute('xmlns:ss:StyleID',"s107" );
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
        $cell1->addAttribute('xmlns:ss:StyleID',"s107" );
        if(isset($staff_[0]->telephoneNumber)){
          $cell1->addChild('Data','м.тел '.$staff_[0]->telephoneNumber)->addAttribute('xmlns:ss:Type',"String" );
        }

        // Идем на хитрость нужно найти более простой способ сохранения переноса строки
        $out_str = str_replace("&#xD;","&#10;", $sxe->asXML()); // преобразуем в xml и делаем замену символа
        file_put_contents('KeysTable.xml', $out_str);
        return response()->download('KeysTable.xml');
    }
}
