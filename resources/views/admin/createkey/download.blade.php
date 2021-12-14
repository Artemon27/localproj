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
        <div class="card-header">
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
                        <th class="p-1 text-center" width="15%" colspan="3">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <form method='post' action="{{route('admin.createkey.store')}}" id='addRoom'>
                        @csrf
                        <td class="p-1 text-center">0</td>
                        <td class="p-1 text-center" ><input type='text' name='otdel'></td>
                        <td class="p-1 text-center"><input type='text' name='penal'></td>
                        <td class="p-1 text-center"><input type='number' name='id_corp'></td>
                        <td class="p-1 text-center"><input type='text' name='id_room' maxlength='15'></td>
                        <td class="p-1 text-center"><input type='text' name='phone'></td>
                        <td class="p-1 text-center"><input type='checkbox' name='imp'></td>
                        <td class="p-1 text-center" colspan="3"><button class="btn btn-success" type="submit">Создать комнату</button></td>
                      </form>
                    </tr>
                    @forelse ($rooms as $room)
                      <tr id='room{{$room->id}}'>
                        <form method="post" action="{{route('admin.createkey.change')}}">
                          @csrf
                          <td class="p-1 text-center">{{$i++}}<input type='hidden' value="{{$room->id}}" name="id" readonly="readonly" style="border: none;"></td>
                          <td class='p-1 text-center'><input value="{{$room->otdel}}" name="otdel" readonly="readonly" style="border: none;"></td>
                          <td class='p-1 text-center'><input value="{{$room->penal}}" name="penal" readonly="readonly" style="border: none;"></td>
                          <td class='p-1 text-center'><input value="{{$room->id_corp}}" name="id_corp" readonly="readonly" style="border: none;" type='number'></td>
                          <td class='p-1 text-center'><input value="{{$room->id_room}}" name="id_room" readonly="readonly" style="border: none;" maxlength='15'></td>
                          <td class='p-1 text-center'><input value="{{$room->phone}}" name="phone" readonly="readonly" style="border: none;"></td>
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
                              </a>
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
                  <td class="p-1 text-center" colspan="5">
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
                  <td class="p-1 text-center"><button class="btn btn-success" type="submit">Добавить</button></td>
                </form>
              </tr>

                    <tr>
                        <th class="p-1 text-center"></th>
                        <th class="p-1 text-center">ФИО, должность</th>
                        <th class="p-1 text-center">Таб.Номер</th>
                        <th class="p-1 text-center">№ печати</th>
                        <th class="p-1 text-center">Домашний телефон</th>
                        <th class="p-1 text-center">Образец подписи</th>
                        <th class="p-1 text-center">Действие</th>
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
                          <td class="p-1 text-center">{{$dates->shortName()}}</td>
                          <td class="p-1 text-center">{{$dates->pager}}</td>
                          <td class="p-1 text-center">{{$dates->pechat}}</td>
                          <td class="p-1 text-center">{{$dates->mobile}}</td>
                          <td class="p-1 text-center"></td>
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
