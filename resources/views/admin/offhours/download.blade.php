@extends('adminlte::page')

@section('title', 'Списки на вечер')

@section('content_header')
    <h1>Списки на вечер</h1>
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
                                <input type='text' name='srch' placeholder='Поиск' size='18' id='srch'>
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
                $i=1;
            @endphp
            <table class=" table-bordered align-middle  mb-0" width="800px">
                <thead>
                    <tr>
                        <th width="10px">№</th>
                        <th class="p-1 text-center">ФИО</th>
                        <th class="p-1 text-center" width="15%">Пропуск</th>
                        <th class="p-1 text-center" width="10%">Помещение</th>
                        <th class="p-1 text-center" width="10%">Телефон</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        @forelse ($user->offHoursDate($date) as $record)
                        <tr>
                            @if ($loop->first)
                            <td class="p-1">{{$i++}}</td>
                            <td class="p-1">{{$user->name}}</td>
                            @else
                            <td></td>
                            <td></td>
                            @endif
                            <!--<td class="p-1 text-center">{{date("d.m.Y",strtotime($record->date))}}</td>-->
                            <td class="p-1 text-center">{{$record->prpsk}}</td>
                            <td class="p-1 text-center">{{$record->room}}</td>
                            <td class="p-1 text-center">{{$record->phone}}</td>
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
