@extends('app')


@section('content')
@php
$calendar = simplexml_load_file('http://elavt.devo/calendar.xml');
 
$calendar = $calendar->days->day;
 
foreach( $calendar as $day ){
    $d = (array)$day->attributes()->d;
    $d = $d[0];
    $d = number_format(substr($d, 3, 2)).'.'.number_format(substr($d, 0, 2));
    if( $day->attributes()->t == 1 ) $arHolidays[] = $d;
}
 
print_r($arHolidays);
@endphp



<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-3">
                <button id="addRow" class="btn-app" type="button">Добавить новую строку</button>
            </div>
        </div>        
    </div>
    <div class="card-body" id="holiday">
        <div class="d-flex flex-wrap justify-content-center">
            @php 
                $n=0;
            @endphp
            @for ($l=0;$l<3;$l++)
                @if ($l==0)
                <div class="month-names">
                    <div class="month-name month-name-1">
                        <div class="month-num">1</div>
                        <div class="month-name-rotate month-name-rotate-1">Январь</div>                    
                    </div>
                    <div class="month-name month-name-2">
                        <div class="month-num">2</div>
                        <div class="month-name-rotate month-name-rotate-2">Февраль</div>         
                    
                    </div>
                    <div class="month-name month-name-3">
                        <div class="month-num">3</div>
                        <div class="month-name-rotate month-name-rotate-3">Март</div>         
                    
                    </div>
                    <div class="month-name month-name-4">
                        <div class="month-num">4</div>
                        <div class="month-name-rotate month-name-rotate-4">Апрель</div>         
                    
                    </div>
                </div>
                @elseif ($l==1)
                <div class="month-names">
                    <div class="month-name month-name-5">
                    Май
                    </div>
                    <div class="month-name month-name-6">
                    Июнь
                    </div>
                    <div class="month-name month-name-7">
                    Июль
                    </div>
                    <div class="month-name month-name-8">
                    Август
                    </div>
                </div>
                @else
                <div class="month-names">
                    <div class="month-name month-name-9">
                    Сентябрь
                    </div>
                    <div class="month-name month-name-10">
                    Октябрь
                    </div>
                    <div class="month-name month-name-11">
                    Ноябрь
                    </div>
                    <div class="month-name month-name-12">
                    Декабрь
                    </div>
                </div>
                @endif
                <table>
                    <tr>
                        <td class="p-2" width="40px">ПН</td>            
                        <td class="p-2" width="40px">ВТ</td>
                        <td class="p-2" width="40px">СР</td>
                        <td class="p-2" width="40px">ЧТ</td>
                        <td class="p-2" width="40px">ПТ</td>
                        <td class="p-2" width="40px">СБ</td>
                        <td class="p-2" width="40px">ВС</td>
                    </tr>            
                @for ($n++;$n<13;$n++)                        
                        @include ('holiday.calendar',['month'=>$n])
                        @if ($n%4 == 0)
                            @break
                        @endif
                @endfor
                </table>
            @endfor
        </div>
    </div>
</div>
@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script>
$(document).ready(function() {
      
    
    
    $('#from, #to').daterangepicker({
    "maxSpan": {
        "days": 28
    },
    "alwaysShowCalendars": true,
    "locale":{
        "format":'DD/MM/YYYY'
    },
    "minDate": "01/01/2022",
    "maxDate": "31/12/2022",
            autoApply: true,
        autoUpdateInput: false
}, function(start, end, label) {

    var selectedStartDate = start.format('DD.MM.YYYY'); // selected start
    var selectedEndDate = end.format('DD.MM.YYYY'); // selected end

    $checkinInput = $('#from');
    $checkoutInput = $('#to');

    // Updating Fields with selected dates
    $checkinInput.val(selectedStartDate);
    $checkoutInput.val(selectedEndDate);

    // Setting the Selection of dates on calender on CHECKOUT FIELD (To get this it must be binded by Ids not Calss)
    var checkOutPicker = $checkoutInput.data('daterangepicker');
    checkOutPicker.setStartDate(selectedStartDate);
    checkOutPicker.setEndDate(selectedEndDate);

    // Setting the Selection of dates on calender on CHECKIN FIELD (To get this it must be binded by Ids not Calss)
    var checkInPicker = $checkinInput.data('daterangepicker');
    checkInPicker.setStartDate(selectedStartDate);
    checkInPicker.setEndDate(selectedEndDate);
});
    
    $('#addRow').click(function () {
      insRow()
    })

    function insRow() {
      let x = $('#holiday');
      x.children(':first-child').clone().appendTo(x);
    }
  });
</script>
@endpush
