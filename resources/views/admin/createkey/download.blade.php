@extends('adminlte::page')

@section('title', 'Выдача ключей')

@section('content_header')

@if($data === -1)
  <h1>Выдача ключей</h1>
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
                        <div class='select'>Выберите ответственного</div>
                        <div class='select_body'>
                          <input type='radio' name='staff' value="Козлов Михаил Вячеславович"> <span>Козлов М.В.</span><br>
                          <input type='radio' name='staff' value="Пластинина Светлана Владимировна"> <span>Пластинина С.В.</span><br>
                          <input type='radio' name='staff' value="Костишин Максим Олегович"> <span>Костишин М.О.</span><br>
                          <input type='radio' name='staff' value="other"> <span><input type='text' name='other_val' placeholder="Другой" size='18'/></span>
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
                        <th class="p-1 text-center" width="15%">№ корпуса<br>№ помещения</th>
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
                        <td class="p-1 text-center"><input type='text' name='corpus_room'></td>
                        <td class="p-1 text-center"><input type='text' name='phone'></td>
                        <td class="p-1 text-center"><input type='checkbox' style="width:40px; height:40px;" name='imp'></td>
                        <td class="p-1 text-center" colspan="3"><button class="btn btn-success" type="submit">Создать комнату</button></td>
                      </form>
                    </tr>
                    @forelse ($rooms as $room)
                      @if(isset($_GET['room_id']) && $room->id == $_GET['room_id'])
                        <tr>
                          <form method="post" action="{{route('admin.createkey.store')}}">
                            @csrf
                            <td class="p-1 text-center">{{$i++}}</td>
                            <td class='p-1 text-center'><input value="{{$room->otdel}}" name="otdel"></td>
                            <td class='p-1 text-center'><input value="{{$room->penal}}" name="penal"></td>
                            <td class='p-1 text-center'><input value="{{$room->corpus_room}}" name="corpus_room"></td>
                            <td class='p-1 text-center'><input value="{{$room->phone}}" name="phone"></td>
                            @if($room->imp=='1')
                              <td class='p-1 text-center'><input type='checkbox' name="imp" style='width:40px; height:40px;' checked></input></td>
                            @else
                              <td class='p-1 text-center'><input type='checkbox' name="imp" style='width:40px; height:40px;'></input></td>
                            @endif
                            <td class='p-1 text-center' colspan="2"><button class='btn btn-success' type='submit'>Сохранить</button></td>
                            <td class='p-1 text-center'><button class='btn btn-danger' onclick='Reload()'>Отмена</button></td>
                          </form>
                        </tr>
                      @else
                        <tr>
                            <td class="p-1 text-center">{{$i++}}</td>
                            <td class="p-1 text-center">{{$room->otdel}}</td>
                            <td class="p-1 text-center">{{$room->penal}}</td>
                            <td class="p-1 text-center">{{$room->corpus_room}}</td>
                            <td class="p-1 text-center">{{$room->phone}}</td>
                            <td class="p-1 text-center">{{$room->imp}}</td>
                            <td class="p-1 text-center">
                              <a href="/admin/createkey/download/{{$room->id}}">
                                <button class="btn btn-success">Просмотр</button>
                              </a>
                            </td>
                            <td class="p-1 text-center">
                              <form method='post' action="{{route('admin.createkey.deleteRoom')}}">
                                @csrf
                                <input type='hidden' value="{{$room->id}}" name='room_id'>
                                <button class="btn btn-danger" type="submit">Удалить</button>
                              </form>
                            </td>
                            <td class="p-1 text-center">
                              <a href="/admin/createkey/download?room_id={{$room->id}}">
                              <button class="btn btn-primary changer">Редактировать</button>
                              </a>
                            </td>
                        </tr>
                      @endif
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
                        <input type='text' name='srch' placeholder='Поиск' size='18' id='srch'>
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
