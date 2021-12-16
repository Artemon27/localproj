@extends('app')


@section('content')
@php
$months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
$year = date('Y');
$month = date('m');
@endphp


<form action="{{ route('offhours.store') }}" method="post">
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
                  @for ($curyear=$year; $curyear<=2023; $curyear++)
                    @for ($n=1;$n<13;$n++)
                      @if($n>=$month && $curyear==$year || $curyear>$year)
                        @if ($curyear==$year and $month==$n)
                        <div class="carousel-item active">
                        @else
                        <div class="carousel-item">
                        @endif
                            <div class="d-flex justify-content-center year-num h2">
                            {{$months[$n]." ".$curyear}}
                            </div>
                            <div class="d-flex flex-wrap justify-content-center" id="calendar">
                                        <div class="d-flex flex-wrap flex-column">
                                        <table>
                                            <tr>
                                                <td class="wd-name p-2 h4" width="90px">ПН</td>
                                                <td class="wd-name p-2 h4" width="90px">ВТ</td>
                                                <td class="wd-name p-2 h4" width="90px">СР</td>
                                                <td class="wd-name p-2 h4" width="90px">ЧТ</td>
                                                <td class="wd-name p-2 h4" width="90px">ПТ</td>
                                                <td class="wd-name p-2 h4" width="90px">СБ</td>
                                                <td class="wd-name p-2 h4" width="90px">ВС</td>
                                            </tr>
                                        </table>
                                                @include ('offHours.calendar',['month'=>$n,'year'=>$curyear])
                                    </div>
                            </div>
                        </div>
                        @endif
                    @endfor
                    @endfor
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Предыдущий</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Следующий</span>
                </button>
            </div>
              <div style="width:40%">
                <div id="carouselExampleControls2" class="carousel slide table-slider p-5 position-relative" data-bs-ride="carousel" data-bs-interval="false">

                    <div class="carousel-inner ms-5" style="height:270px">
                        @include ('offHours.table',['dates'=>$dates])
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Предыдущий</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Следующий</span>
                      </button>
                      <div id='list' class="text-center">
                        <button type='button' data-bs-target="#carouselExampleControls2" data-bs-slide-to='0' area-label='Стр.1' class='active' aria-current='true'></button>
                        <button type='button' data-bs-target="#carouselExampleControls2" data-bs-slide-to='1' area-label='Стр.2'></button>
                        <button type='button' data-bs-target="#carouselExampleControls2" data-bs-slide-to='2' area-label='Стр.3'></button>
                      </div>
              </div>
        </div>
    </div>
</form>
@endsection

@push('beforescripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" disabled="1" href="{{ asset('css/calendar2.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendarDark2.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/offHours.js') }}"></script>
<script>
var numdays = {{old('numdays') ?? $numdays}};
var prpsk = '{{$prpsk}}'
var room = '{{$room}}'
var phone = '{{$phone}}'
</script>
@endpush
