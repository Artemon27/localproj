@extends('app')


@section('content')
@php
$months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
$year = date('Y');
$month = date('m');
@endphp

    <div class="card">
      <div class="card-header">
          <div class="row">
              <div class="col-2">
                  <div id="theme" class="btn btn-sm btn-outline-primary">Сменить тему</div>
              </div>
              <div class="col-2">

              </div>
              <div class="col-1">

              </div>
              <div class="col-2 text-center">

              </div>
              <div class="col-3 text-end">
                  <div class="row">

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
                  <div class="d-flex justify-content-center year-num h5 p-5">Вам предоставлен доступ в следующие помещения</div>
                  <table>
                    <thead>
                      <tr>
                        <th class="h5 text-center" width="50%">Расположение помещения</td>
                        <th class="h5 text-center" width="25%">№ пенала</td>
                          <th class="h5 text-center" width="25%">Телефон</td>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($room_pers as $rp)
                          @forelse ($rooms as $room)
                            @if($rp->room_id == $room->id)
                              <tr>
                                <td class="h5 month-11 p-2">Корпус {{$room->id_corp}} Помещение {{$room->id_room}}</td>
                                <td class="h5 month-11 p-2">{{$room->penal}}</td>
                                <td class="h5 month-11 p-2">{{$room->phone}}</td>
                              </tr>
                              @break
                            @endif
                          @empty
                          @endforelse
                        @empty
                        @endforelse
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

@endsection

@push('beforescripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" disabled="1" href="{{ asset('css/calendar3.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendarDark3.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/timeSheet.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
@endpush
