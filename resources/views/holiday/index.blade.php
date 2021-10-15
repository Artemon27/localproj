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
$year=2022;
@endphp



<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                <button id="btn-off" class="btn btn-sm btn-outline-primary">Очистить</button>
            </div>
            <div class="col-2">
                <button id="btn-off" class="btn btn-sm btn-outline-primary">Очистить</button>
            </div>
            <div class="col-4 text-center">
                <div id="numdays"></div>
            </div>
            <div class="col-2 text-end">
                <button id="theme" class="btn btn-sm btn-outline-primary">Сменить тему</button>   
            </div>  
            <div class="col-2 text-end">
                 <button id="" class="btn btn-sm btn-outline-primary">Сохранить</button>   
            </div>            
        </div>        
    </div>
    <div class="card-body" id="holiday">
        <div class="d-flex justify-content-center year-num">
            {{$year}}
        </div>
        <div class="d-flex flex-wrap justify-content-center">
            @php 
                $n=0;
            @endphp
            @for ($l=0;$l<3;$l++)
                <div class="d-flex flex-wrap flex-column">
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
                            @include ('holiday.calendar',['month'=>$n,'year'=>$year])
                            @if ($n%4 == 0)
                                @break
                            @endif
                    @endfor
                </div>
                
            @endfor
        </div>
    </div>
</div>
@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
<link rel="stylesheet" disabled="1" href="{{ asset('css/calendar.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendarDark.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script>
var numdays = 28;   
$('#btn-off').click(function(){
    $('body input:checkbox').each(function() {
        if ($(this).attr('checked')){
            $(this).removeAttr('checked');
            numdays++;
        }
   });
   updatenum(numdays);
}); 

var isMouseDown;
$('body .btn-submit').mousedown(function(e) {     
    if ($(this).parent().children('input').attr('checked')){
        $(this).parent().children('input').removeAttr('checked');
        numdays++;
        updatenum(numdays);
        $('body .btn-submit').on('mouseenter',function(){
            if ($(this).parent().children('input').attr('checked')){
                $(this).parent().children('input').removeAttr('checked');
                numdays++;
                updatenum(numdays);
            }
        });
    }
    else{
        if (numdays>0){
            $(this).parent().children('input').attr('checked', 'checked')
            numdays--;
            updatenum(numdays);
        }        
        $('body .btn-submit').on('mouseenter',function(){        
            if ((!$(this).parent().children('input').attr('checked'))&&(numdays>0)){
                $(this).parent().children('input').attr('checked', 'checked');
                numdays--;
                updatenum(numdays);
            }
        });
    }
})  
    .click(function(e){
         e.preventDefault();
     });

function updatenum(n){
    $('#numdays').html('Оставшиеся дни: '+ n);
}


$(document).mouseup (function() {  
  $('body .btn-submit').off('mouseenter');
});
   

$(document).ready(function() {    
   updatenum(numdays);
 });    
 
$('#theme').click(function(e){
    if ($('link[href*="calendar.css"]').prop('disabled')){
        $('link[href*="calendar.css"]').prop('disabled', false);
        $('link[href*="calendarDark.css"]').prop('disabled', true);
    }
    else{
        $('link[href*="calendar.css"]').prop('disabled', true);
        $('link[href*="calendarDark.css"]').prop('disabled', false);
    }
});

</script>
@endpush
