@extends('adminlte::page')

@section('title', 'Списки на вечер')

@section('content_header')
    <h1>Табель учета рабочего времени</h1>
@endsection

@section('content')

<div class="card">
        <div class="card-header">
                <div class="d-flex flex-row">
                    <div class="p-2 m-2">
                        Дата:
                    </div>
                    <div class="p-2 m-2">
                        <input id="date" type="date" value="{{$date}}" />
                    </div>
                    <div class="p-2">
                        <a onclick="goToDate()" class="btn btn-outline-primary">Выбрать</a>
                    </div>
                    <div class="ml-auto p-2">
                        <form action="{{ route('admin.offhours.offHoursTable') }}" method="post">
                            @csrf
                            <div style="float:left"><input name="thing" type="text" placeholder="Тема" size="20"/></div>
                            <div style="float:left">
                              <div class='select'>
                                Выбрать ответственного
                              </div>
                              <div class='select_body'>
                                <input type='text' name='srch' placeholder='Поиск' size='18' class='srch'>
                                <div>
                                  @forelse ($users as $i => $value)
                                  <div><input type='radio' name='staff_id' value="{{$value->id}}"><span>{{$value->shortName()}}</span></div>
                                  @empty
                                  @endforelse
                                </div>
                              </div>
                            </div>
                            <div style="float:left">
                              <input name="date" type="hidden" value="{{$date}}" />
                              <button class="btn btn-success" style="margin-left:20px" type="submit">Создать таблицу</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        @include ('modules.messages')
        <div class="card-body" id="holiday">
            @php
                $j=1;
            @endphp
            <table class=" table-bordered align-middle  mb-0" width="800px">
                <thead>
                    <tr>
                        <th width="10px">№</th>
                        <th class="p-1 text-center" width="25%">ФИО</th>
                        <th class="p-1 text-center" width="15%">Пропуск</th>
                        <th class="p-1 text-center" width="10%">Помещение</th>
                        <th class="p-1 text-center" width="10%">Телефон</th>
                        <th class="p-1 text-center" width="10%" colspan="2">Действие</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <form method='post' action="{{route('admin.offhours.storepers')}}">
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
                        <input type='hidden' name='date' value='{{$date}}'>
                      </td>
                      <td class="p-1 text-center" colspan="2"><button class="btn btn-success" type="submit">Добавить</button></td>
                    </form>
                  </tr>
                    @forelse ($users as $user)
                        @forelse ($user->offHoursDate($date) as $record)
                        <tr>
                          <form method="post" action="{{route('admin.offhours.change')}}">
                            @csrf
                            <td class="p-1">{{$j++}}</td>
                            <td class="p-1 text-center"><input value="{{$user->name}}" name="name" readonly="readonly" style="border: none;" size='30'></td>
                            <td class="p-1 text-center"><input value="{{$record->prpsk}}" name="prpsk" readonly="readonly" style="border: none;"size='10'></td>
                            <td class="p-1 text-center"><input value="{{$record->room}}" name="room" readonly="readonly" style="border: none;"size='10'></td>
                            <td class="p-1 text-center"><input value="{{$record->phone}}" name="phone" readonly="readonly" style="border: none;"size='10'></td>

                            <td class="p-1 text-center" style="display:none;">
                                    <input type='hidden' name='id' value="{{$record->id}}"><button class="btn btn-success" type='submit'>Сохранить</button>
                            </td>
                          </form>
                          <td class="p-1 text-center" style="display:none;">
                                  <button class="btn btn-danger" onclick='Reload()'>Отмена</button>
                          </td>
                          <td class="p-1 text-center">
                                <form method='post' action="{{route('admin.offhours.delPers')}}" style="display: inline-table;">
                                  @csrf
                                  <input type='hidden' value="{{$user->id}}" name='user_id'>
                                  <input type='hidden' value="{{$date}}" name='date'>
                                  <button class="btn btn-danger" type="submit">Удалить</button>
                                </form>
                          </td>
                          <td class="p-1 text-center">
                                <button class="btn btn-primary changer user{{$user->id}}" >Редактировать</button>
                                </a>
                          </td>
                        </tr>
                        @empty
                        @endforelse
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('css')
@endpush
@push('js')
<script src="{{asset('js/adminjs.js')}}"></script>
<script>
function goToDate(){
    var date = $('#date').val();
    if (Date.parse(date)>=Date.now()-3600*1000*24)
    {
        console.log(date);
        window.location.href = "{{ route('admin.offhours.download') }}/" + date;
    }
}

</script>
@endpush
