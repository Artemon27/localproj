@extends('app')


@section('content')
@php

$year=2022;
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
                    @for ($curyear=$year-1; $curyear<$year+2; $curyear++)
                        @if ($curyear==$year)
                        <div class="carousel-item active">
                        @else
                        <div class="carousel-item">
                        @endif
                            <div class="d-flex justify-content-center year-num">
                            {{$curyear}}
                            </div>
                            <div class="d-flex flex-wrap justify-content-center" id="calendar">
                                @php
                                    $n=0;
                                @endphp
                                @for ($l=0;$l<3;$l++)
                                    @if ($l==0)
                                        <div class="d-flex flex-wrap flex-column cal-col-1">
                                    @else
                                        <div class="d-flex flex-wrap flex-column">
                                    @endif
                                        <table>
                                            <tr>
                                                <td width="100px"></td>
                                                <td class="wd-name p-2" width="40px">ПН</td>
                                                <td class="wd-name p-2" width="40px">ВТ</td>
                                                <td class="wd-name p-2" width="40px">СР</td>
                                                <td class="wd-name p-2" width="40px">ЧТ</td>
                                                <td class="wd-name p-2" width="40px">ПТ</td>
                                                <td class="wd-name p-2" width="40px">СБ</td>
                                                <td class="wd-name p-2" width="40px">ВС</td>
                                            </tr>
                                        </table>
                                        @for ($n++;$n<13;$n++)
                                                @include ('holiday.calendar',['month'=>$n,'year'=>$curyear])
                                                @if ($n%4 == 0)
                                                    @break
                                                @endif
                                        @endfor
                                    </div>

                                @endfor
                            </div>
                        </div>
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
            @include ('offHours.table',['dates'=>$dates])
        </div>
    </div>
</form>
@endsection

@push('beforescripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" disabled="1" href="{{ asset('css/calendar.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendarDark.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/offHours.js') }}"></script>
<script>
var numdays = {{old('numdays') ?? $numdays}};


</script>
@endpush
