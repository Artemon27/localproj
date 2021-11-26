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
                      <input type='hidden' name='room_id' value='{{$data[0]->id}}'>
                      <button class="btn btn-success" type="submit">Создать таблицу</button>
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
                        <th class="p-1 text-center" width="10%">Важность</th>
                        <th class="p-1 text-center" width="15%">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <form method='post' action="{{route('admin.createkey.store')}}">
                        @csrf
                        <td class="p-1 text-center">0</td>
                        <td class="p-1 text-center" ><input type='text' name='otdel'></td>
                        <td class="p-1 text-center"><input type='text' name='penal'></td>
                        <td class="p-1 text-center"><input type='text' name='corpus_room'></td>
                        <td class="p-1 text-center"><input type='text' name='phone'></td>
                        <td class="p-1 text-center"><input type='checkbox' style="width:40px; height:40px;" name='imp'></td>
                        <td class="p-1 text-center"><button class="btn btn-success" type="submit">Создать комнату</button></td>
                      </form>
                    </tr>
                    @forelse ($rooms as $room)
                      <tr>
                          <td class="p-1 text-center">{{$i++}}</td>
                          <td class="p-1 text-center">{{$room->otdel}}</td>
                          <td class="p-1 text-center">{{$room->penal}}</td>
                          <td class="p-1 text-center">{{$room->corpus_room}}</td>
                          <td class="p-1 text-center">{{$room->phone}}</td>
                          <td class="p-1 text-center">{{$room->imp}}</td>
                          <td class="p-1 text-center"><a href="/admin/createkey/download/{{$room->id}}"><button class="btn btn-success">Просмотр</button></a></td>
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
                        <th class="p-1 text-center">ФИО, должность</th>
                        <th class="p-1 text-center">Таб.Номер</th>
                        <th class="p-1 text-center">№ печати</th>
                        <th class="p-1 text-center">Домашний телефон</th>
                        <th class="p-1 text-center">Образец подписи</th>
                        <th class="p-1 text-center">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <form method='post' action="{{route('admin.createkey.storepers')}}">
                        @csrf
                        <td class="p-1 text-center" colspan="5">
                          <input type='text' name='srch' placeholder='Поиск' size='15' id='srch'>
                          <select name='pers'>
                            <option value='g'>Выберите кого добавить</option>
                            @forelse ($users as $value)
                              <option value='{{$value->id}}'>{{$value->shortName()}}</option>
                            @empty
                            @endforelse
                          </select>
                          <input type='hidden' name='room' value='{{$data[0]->id}}'>
                        </td>
                        <td class="p-1 text-center"><button class="btn btn-success" type="submit">Добавить</button></td>
                      </form>
                    </tr>
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
                          <td class="p-1 text-center"></td>
                          <td class="p-1 text-center"></td>
                          <td class="p-1 text-center"></td>
                          <td class="p-1 text-center">
                            <form method="post" action="{{route('admin.createkey.delpers')}}">
                              @csrf
                              <input type='hidden' name='user_id' value='{{$dates->id}}'>
                              <input type='hidden' name='room_id' value='{{$data[0]->id}}'>
                              <button class="btn btn-success" type="submit">Удалить</button>
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
<script>
$('#srch').keyup(function(){
  let val = this.value;
  if(val != ''){
    $('option').each(function(i){
      $(this).css('display','none')
      if(find(this.text, val)>=0){
        $(this).css('display','block')
      }
    });
  }else{
    $('option').each(function(i){
      $(this).css('display','block')
    });
  }

});

function find (text, pattern){
  t = 0
  last = pattern.length-1
  while (t < pattern.length-last){
    p=0
    while(p<=last && text[t+p] == pattern[p]){
      p++
    }
    if(p==pattern.length){
      return t
    }
    t++
  }
  return -1
}

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
