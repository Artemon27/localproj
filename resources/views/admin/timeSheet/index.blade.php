@extends('app')


@section('content')
@php
  $months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
  $dates = array('prev' => array('month'=> '', 'year'=>''), 'cur' => array('month'=> (int) date('m'), 'year'=>(int) date('Y')),'next' => array('month'=> '', 'year'=>''));
  $year = $dates['cur']['year'];
  $month = $dates['cur']['month'];
@endphp

@if($dates['cur']['month']+1 >12)
  @php
    $dates['next']['month'] =1;
    $dates['next']['year'] = $dates['cur']['year']+1;
  @endphp
@else
  @php
    $dates['next']['month']=$dates['cur']['month'] +1;
    $dates['next']['year'] = $dates['cur']['year'];
  @endphp
@endif

@if($dates['cur']['month']-1 < 1)
  @php
    $dates['prev']['month'] =12;
    $dates['prev']['year'] = $dates['cur']['year']-1;
  @endphp
@else
  @php
    $dates['prev']['month']=$dates['cur']['month'] -1;
    $dates['prev']['year'] = $dates['cur']['year'];
  @endphp
@endif
<form action="{{ route('admin.timeSheet.chose') }}" method="post">
    @csrf
    <div class="form-group w-50 m-auto mt-3 mb-3 ">
        <div class="row">
            <div class="col-2">
                <label for="parent_id">Имя пользователя</label>
            </div>
            <div class="col">
                @include('modules.choseUser')
            </div>
            <div class="col"><button href="" class="btn btn-btn btn-sm btn-outline-primary">Выбрать</button></div>
        </div>
    </div>
</form>
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
              </div>
              <div class="col-3 text-end">
                <div class="col" style="float:left">
                  <a target="_blank" href="{{ asset('Instruction.pdf') }}" class="btn btn-sm btn-outline-success">Инструкция</a>
                </div>
                <form action="{{ route('admin.timeSheet.store') }}" method="post" align="center" style="float:left; margin-left:50px;">
                  @csrf
                  <input class="id" type="hidden" value="{{$user->id}}" name="id">
                  <input class="monthIn" type="hidden" value="{{$month}}" name="month">
                  <input class="yearIn" type="hidden" value="{{$year}}" name="year">
                  <button class="btn btn-sm btn-outline-primary" type="submit">Сформировать табель</button>
                </form>
                <div class="col" style="float:left">
                  <form action="{{ route('admin.timeSheet.store') }}" method="post">
                    @csrf
                    <input class="id" type="hidden" value="{{$user->id}}" name="id">
                    <input id="monthIn" type="hidden" value="{{$month}}" name="month">
                    <input id="yearIn" type="hidden" value="{{$year}}" name="year">
                  <button href="" class="btn btn-btn btn-sm btn-outline-primary">Сохранить</button>
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
                  @foreach($dates as $key => $curmonth)
                        @if ($key=='cur')
                        <div class="carousel-item active">
                        @else
                        <div class="carousel-item">
                        @endif
                            <div class="d-flex justify-content-center year-num" num-mon="{{$curmonth['month']}}" num-year="{{$curmonth['year']}}">
                            {{$months[$curmonth['month']]." ".$curmonth['year']}}
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

                                                @include ('admin.timeSheet.calendar',['month'=>$curmonth['month'],'year'=>$curmonth['year']])
                                    </div>
                            </div>
                        </div>
                    @endforeach
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
        </div>
    </div>
</form>


@endsection

@push('beforescripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendar3.css') }}">
<link rel="stylesheet" disabled="1" href="{{ asset('css/calendarDark3.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/timeSheet.js') }}"></script>
@endpush
