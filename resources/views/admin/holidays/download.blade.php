@extends('adminlte::page')

@section('title', 'Таблица отпусков')

@section('content_header')
    <h1>Таблица отпусков</h1>
@endsection

@section('content')

<div class="card">
        <div class="card-header">       
                <div class="d-flex flex-row">
                    <div class="p-2 m-2">
                        Год:
                    </div>                    
                    <div class="p-2 m-2">                  
                        <input id="year" type="number" min="2022" max="2099" step="1" value="{{$year}}" />                                           
                    </div>
                    <div class="p-2">
                        <a onclick="goToYear()" class="btn btn-outline-primary">Выбрать</a>
                    </div>                   
                    <div class="ml-auto p-2">
                        <form action="{{ route('admin.holidays.holiTable') }}" method="post">
                            @csrf
                            <input name="year" type="hidden" value="{{$year}}" />     
                            <button class="btn btn-success" type="submit">Создать таблицу</button>
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
                        <th class="p-1 text-center" width="15%">Дата начала</th>
                        <th class="p-1 text-center" width="10%">Дней</th>
                        <th class="p-1 text-center" width="10%">ПВТ</th>
                        <th class="p-1 text-center" width="10%">ИНВ</th>
                        <th class="p-1 text-center" width="10%">ОБ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        @forelse ($user->holidaysYear($year) as $holiday)
                        <tr>
                            @if ($loop->first)
                            <td class="p-1">{{$i++}}</td>
                            <td class="p-1">{{$user->name}}</td>
                            @else
                            <td></td>
                            <td></td>
                            @endif
                            <td class="p-1 text-center">{{date("d.m.Y",strtotime($holiday->datefrom))}}</td>
                            <td class="p-1 text-center">{{$holiday->days}}</td>
                            <td class="p-1 text-center">{{$holiday->PVT}}</td>
                            <td class="p-1 text-center">{{$holiday->INV}}</td>
                            <td class="p-1 text-center">{{$holiday->OB}}</td>
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
<script>
function goToYear(){
    var year = $('#year').val();
    if ((year>2021)&&(year<2099))
    {
        window.location.href = "{{ route('admin.holidays.download') }}/" + year;
    }       
}

</script>
@endpush
