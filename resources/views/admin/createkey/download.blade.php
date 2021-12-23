@extends('adminlte::page')

@section('title', 'Выдача ключей')

@section('content_header')

@if($data === -1)
   <div class="row">
      <div class="col">
         <h1>Выдача ключей</h1>
      </div>
         <div class="col">
      </div>
   </div>
@else
  <h1>Выдача ключей {{$data[0]->corpus_room}}</h1>
@endif

@endsection

@section('content')

<div class="card">
      @if($data === -1)
        <div class="card-header d-flex flex-row">
          <div class="m-0 p-2">
            <form action="{{ route('admin.createkey.search') }}" method="post" >
              @csrf
              <input type='text' name='srch'>
              <button class="btn btn-success" type="submit">Поиск</button>
            </form>
          </div>
          <div class="ml-auto p-2">
            <form action="{{ route('admin.createkey.CreateKeyTable') }}" method="post" class="text-right">
              @csrf
                <div class="m-10" style="float:left">
                  <div class='select'>
                    Выбрать ответственного
                  </div>
                  <div class='select_body'>
                    <input type='text' name='srch' placeholder='Поиск' size='18' class='srch'>
                    <div>
                      @forelse ($users as $i => $value)
                      <div><input type='radio' name='staff' value="{{$value->id}}"><span>{{$value->shortName()}}</span></div>
                      @empty
                      @endforelse
                    </div>
                  </div>
              </div>
              <input type='hidden' name='rooms'>
              <input type='hidden' name='room_id' value='none'>
              <button class="btn btn-success" type="submit">Создать таблицу</button>
            </form>
          </div>
        </div>
        @else
        <div class="card-header">
          <div class="d-flex flex-row">
              <div class="p-2 m-0">
                  <a href="/admin/createkey/download"><button class="btn btn-success">Назад</button></a>
              </div>
              <div class="ml-auto p-2">
                  <form action="{{ route('admin.createkey.CreateKeyTable') }}" method="post">
                      @csrf
                      <div class="m-10" style="float:left">
                        <div class='select'>
                          Выбрать ответственного
                        </div>
                        <div class='select_body'>
                          <input type='text' name='srch' placeholder='Поиск' size='18' class='srch'>
                          <div>
                            @forelse ($users as $i => $value)
                            <div><input type='radio' name='staff' value="{{$value->id}}"><span>{{$value->shortName()}}</span></div>
                            @empty
                            @endforelse
                          </div>
                        </div>
                    </div>
                      <div style="float:left">
                        <input type='hidden' name='room_id' value='{{$data[0]->id}}'>
                        <input type='hidden' name='rooms' value='none'>
                        <button class="btn btn-success" style="margin-left:20px" type="submit">Создать таблицу</button>
                      </div>
                  </form>
              </div>
          </div>
        </div>
        @endif
        @include ('modules.messages')
        @if($data === -1)
        <div class="card-body" id="holiday">
            @php
                $i=1;
            @endphp
            <table class=" table-bordered align-middle  mb-0" width="800px">
                <thead>
                    <tr>
                        <th class="p-1 text-center" width="5%">№</th>
                        <th class="p-1 text-center" width="15%">Отдел</th>
                        <th class="p-1 text-center" width="5%">№ пенала</th>
                        <th class="p-1 text-center" width="7%">№ корпуса</th>
                        <th class="p-1 text-center" width="8%">№ помещения</th>
                        <th class="p-1 text-center" width="10%">Местный телефон</th>
                        <th class="p-1 text-center" width="10%">Режимное помещение</th>
                        <th class="p-1 text-center" width="15%" colspan="4">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <form method='post' action="{{route('admin.createkey.store')}}" id='addRoom'>
                        @csrf
                        <td class="p-1 text-center">0</td>
                        <td class="p-1 text-center" ><input type='text' name='otdel' size='12'></td>
                        <td class="p-1 text-center"><input type='text' name='penal' size='3'></td>
                        <td class="p-1 text-center"><input type='text' name='id_corp' size='2'></td>
                        <td class="p-1 text-center"><input type='text' name='id_room' size='4'></td>
                        <td class="p-1 text-center"><input type='text' name='phone' size='5'></td>
                        <td class="p-1 text-center"><input type='checkbox' name='imp'></td>
                        <td class="p-1 text-center" colspan="4"><button class="btn btn-success" type="submit">Создать комнату</button></td>
                      </form>
                    </tr>
                    @forelse ($rooms as $room)
                      <tr id='room{{$room->id}}'>
                        <form method="post" action="{{route('admin.createkey.change')}}">
                          @csrf
                          <td class="p-1 text-center">{{$i++}}<input type='hidden' value="{{$room->id}}" name="id" readonly="readonly" style="border: none;"></td>
                          <td class='p-1 text-center'><input value="{{$room->otdel}}" name="otdel" readonly="readonly" size='12' style="border: none;"></td>
                          <td class='p-1 text-center'><input value="{{$room->penal}}" name="penal" readonly="readonly" size='3' style="border: none;"></td>
                          <td class='p-1 text-center'><input value="{{$room->id_corp}}" name="id_corp" readonly="readonly" size='2' style="border: none;"></td>
                          <td class='p-1 text-center'><input value="{{$room->id_room}}" name="id_room" readonly="readonly" size='4' style="border: none;" maxlength='15'></td>
                          <td class='p-1 text-center'><input value="{{$room->phone}}" name="phone" readonly="readonly" size='5' style="border: none;"></td>
                          @if($room->imp=='1')
                            <td class='p-1 text-center'><input type='checkbox' name="imp" checked readonly="readonly" style="border: none;" onclick="return false;"></input></td>
                          @else
                            <td class='p-1 text-center'><input type='checkbox' name="imp" readonly="readonly" style="border: none;" onclick="return false;"></input></td>
                          @endif
                          <td class="p-1 text-center" style="display:none;" colspan="2">
                                  <button class="btn btn-success" type='submit'>Сохранить</button>
                          </td>
                        </form>
                        <td class="p-1 text-center" style="display:none;">
                                <button class="btn btn-danger" onclick='Reload()'>Отмена</button>
                        </td>
                        <td class="p-1 text-center">
                                <a href="/admin/createkey/download/{{$room->id}}">
                                <button class="btn btn-success">Просмотр</button>
                              </a>
                        </td>
                        <td class="p-1 text-center">
                              <form method='post' action="{{route('admin.createkey.deleteRoom')}}" style="display: inline-table;">
                                @csrf
                                <input type='hidden' value="{{$room->id}}" name='room_id'>
                                <button class="btn btn-danger" type="submit">Удалить</button>
                              </form>
                        </td>
                        <td class="p-1 text-center">
                              <button class="btn btn-primary changer room{{$room->id}}" >Редактировать</button>
                        </td>
                        <td class="p-1 text-center">
                                <button class="btn btn-success button-select">+</button>
                        </td>
                      </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        @else
        <div class="card-body" id="holiday">
            @php
                $i=1;
            @endphp
            <table class=" table-bordered align-middle  mb-0" width="800px">
              <thead>
              <tr>
                <form method='post' action="{{route('admin.createkey.storepers')}}">
                  @csrf
                  <td class="p-1 text-center" colspan="7">
                      <div class='select'>
                        Выбрать пользователей
                      </div>
                      <div class='select_body'>
                        <input type='text' name='srch' placeholder='Поиск' size='18' class='srch'>
                        <div>
                          @forelse ($users as $i => $value)
                          <div><input type='checkbox' name='pers[{{$i}}]' value="{{$value->id}}"> <span>{{$value->shortName()}}</span></div>
                          @empty
                          @endforelse
                        </div>
                      </div>
                    <input type='hidden' name='room' value='{{$data[0]->id}}'>
                  </td>
                  <td class="p-1 text-center" colspan="2"><button class="btn btn-success" type="submit">Добавить</button></td>
                </form>
              </tr>

                    <tr>
                        <th class="p-1 text-center"></th>
                        <th class="p-1 text-center">ФИО</th>
                        <th class="p-1 text-center">Должность</th>
                        <th class="p-1 text-center">Таб.Номер</th>
                        <th class="p-1 text-center">№ печати</th>
                        <th class="p-1 text-center">Домашний телефон</th>
                        <th class="p-1 text-center">Образец подписи</th>
                        <th class="p-1 text-center" colspan="2">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staff as $pers)
                      @forelse ($users as $value)
                        @if($value->id == $pers->user_id)
                          @php
                            $dates = $value;
                            break;
                          @endphp
                        @endif
                      @empty
                      @endforelse
                      <tr>
                          <td class="p-1 text-center">
                              @include('modules.toggle', ['model' => $pers, 'toggle' => 'main'])
                          </td>
                          <form method="post" action="{{route('admin.createkey.changepers')}}">
                            @csrf
                            @if($pers['name_post']!=null)
                              <td class="p-1 text-center"><input value="{{$pers['name_staff']}}" name="name_staff" readonly="readonly" style="border: none;"></td>
                              <td class="p-1 text-center"><input value="{{$pers['name_post']}}" name="name_post" readonly="readonly" style="border: none;"></td>
                              <td class="p-1 text-center"><input value="{{$pers['pager']}}" name="pager" readonly="readonly" style="border: none;" size='10'></td>
                              <td class="p-1 text-center"><input value="{{$pers['pechat']}}" name="pechat" readonly="readonly" style="border: none;" size='8'></td>
                              <td class="p-1 text-center"><input value="{{$pers['mobile']}}" name="mobile" readonly="readonly" style="border: none;"></td>
                            @else
                              <td class="p-1 text-center"><input value="{{$dates->shortName()}}" name="name_staff" readonly="readonly" style="border: none;"></td>
                              <td class="p-1 text-center"><input value="{{$dates->title}}" name="name_post" readonly="readonly" style="border: none;"></td>
                              <td class="p-1 text-center"><input value="{{$dates->pager}}" name="pager" readonly="readonly" style="border: none;" size='10'></td>
                              <td class="p-1 text-center"><input value="{{$dates->pechat}}" name="pechat" readonly="readonly" style="border: none;" size='8'></td>
                              <td class="p-1 text-center"><input value="{{$dates->mobile}}" name="mobile" readonly="readonly" style="border: none;"></td>
                            @endif
                          <td class="p-1 text-center"></td>
                          <td class="p-1 text-center" style="display:none;">
                            <input type='hidden' name='user_id' value='{{$dates->id}}'>
                            <input type='hidden' name='room_id' value='{{$data[0]->id}}'>
                            <button class="btn btn-success" type='submit'>Сохранить</button>
                          </td>
                        </form>
                        <td class="p-1 text-center" style="display:none;">
                                <button class="btn btn-danger" onclick='Reload()'>Отмена</button>
                        </td>
                        <td class="p-1 text-center">
                              <button class="btn btn-primary changer keypers-k" >Редактировать</button>
                              </a>
                        </td>
                        <td class="p-1 text-center">
                          <form method="post" action="{{route('admin.createkey.delpers')}}">
                            @csrf
                            <input type='hidden' name='user_id' value='{{$dates->id}}'>
                            <input type='hidden' name='room_id' value='{{$data[0]->id}}'>
                            <button class="btn btn-danger" type="submit">Удалить</button>
                          </form>
                        </td>
                      </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
    </div>

@endsection

@push('css')
@endpush
@push('js')
<script src="{{asset('js/adminjs.js')}}"></script>
@endpush
