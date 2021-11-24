@extends('app')


@section('content')
@php
$months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
$year = date('Y');
$month = date('m');
@endphp


<form action="{{ route('timeSheet.store') }}" method="post">
    @csrf
    <div class="card">
      <div class="card-header">
          <div class="row">
              <div class="col-2">
                  <div id="theme" class="btn btn-sm btn-outline-primary">Сменить тему</div>
              </div>
              <div class="col-2">
                  <div id="btn-off" class="btn btn-sm btn-outline-primary">Очистить</div>
              </div>
              <div class="col-1">

              </div>
              <div class="col-2 text-center">
                  <div id="numdays"></div>
                  <input id="numdaysIn" type="hidden" value="{{old('numdays') ?? 0}}" name="numdays">
                  <input id="monthIn" type="hidden" value="{{$month}}" name="month">
                  <input id="yearIn" type="hidden" value="{{$year}}" name="year">
              </div>
              <div class="col-3 text-end">
                  <div class="row">
                      <div class="col"><a target="_blank" href="{{ asset('Instruction.pdf') }}" class="btn btn-sm btn-outline-success">Инструкция</a></div>
                      <div class="col"><button href="" class="btn btn-btn btn-sm btn-outline-primary">Сохранить</button></div>
                  </div>
              </div>
              <div class="col-2 text-end">
                  @include ('modules.menu')
              </div>
          </div>
      </div>
      @include('modules.messages')
        <div class="card-body d-flex justify-content-center align-items-start" id="holiday">
            <div id="carouselExampleControls" class="carousel slide holiday-slider" data-bs-ride="carousel" data-bs-interval="false">
                <div class="carousel-inner">
                  <div class="d-flex justify-content-center year-num h2">Табель учета рабочего времени</div>
                  @for ($curyear=2021; $curyear<=2023; $curyear++)
                    @for ($n=1;$n<13;$n++)
                        @if ($curyear==$year and $month==$n)
                        <div class="carousel-item active">
                        @else
                        <div class="carousel-item">
                        @endif
                            <div class="d-flex justify-content-center year-num">
                            {{$months[$n]." ".$curyear}}
                            </div>
                            <div class="d-flex flex-wrap justify-content-center" id="calendar">

                                        <div class="d-flex flex-wrap flex-column">

                                        <table>
                                            <tr>
                                                <td class="wd-name p-2 h4" width="150px">ПН</td>
                                                <td class="wd-name p-2 h4" width="150px">ВТ</td>
                                                <td class="wd-name p-2 h4" width="150px">СР</td>
                                                <td class="wd-name p-2 h4" width="150px">ЧТ</td>
                                                <td class="wd-name p-2 h4" width="150px">ПТ</td>
                                                <td class="wd-name p-2 h4" width="150px">СБ</td>
                                                <td class="wd-name p-2 h4" width="150px">ВС</td>
                                            </tr>
                                        </table>

                                                @include ('timeSheet.calendar',['month'=>$n,'year'=>$curyear])
                                    </div>
                            </div>
                        </div>
                    @endfor
                    @endfor
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('timeSheet.store') }}" method="post" align="center">
  @csrf
  <input class="monthIn" type="hidden" value="{{$month}}" name="month">
  <input class="yearIn" type="hidden" value="{{$year}}" name="year">
  <button class="btn btn-sm btn-outline-primary" type="submit" style="width: 25%;  height: 80px; font-size: 14pt;">Сформировать табель</button>
</form>

@endsection

@push('beforescripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" disabled="1" href="{{ asset('css/calendar.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendarDark3.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/timeSheet.js') }}"></script>
<script>
var numdays = {{old('numdays') ?? $numdays}};
</script>
@endpush
