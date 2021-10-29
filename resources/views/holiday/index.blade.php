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


<form action="{{ route('holiday.store') }}" method="post">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-2">
                    <div id="btn-off" class="btn btn-sm btn-outline-primary">Очистить</div>
                </div>
                <div class="col-2">
                    <div id="btn-off" class="btn btn-sm btn-outline-primary">Очистить</div>
                </div>
                <div class="col-4 text-center">
                    <div id="numdays"></div>
                    <input id="numdaysIn" type="hidden" value="{{old('numdays') ?? 0}}" name="numdays">
                </div>
                <div class="col-2 text-end">
                    <div id="theme" class="btn btn-sm btn-outline-primary">Сменить тему</div>   
                </div>  
                <div class="col-2 text-end">
                     <button id="" class="btn btn-sm btn-outline-primary">Сохранить</button>   
                </div>            
            </div>        
        </div>
        @include ('modules.messages')
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
            @include ('holiday.table')
        </div>
    </div>
</form>
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
var numdays = {{old('numdays') ?? $numdays}};   
var mouse=0;
var strDays = [];

$('#btn-off').click(function(){
    $('body input:checkbox').each(function() {
        if ($(this).attr('checked')){
            $(this).removeAttr('checked');
            numdays--;
        }
   });
   updatenum(numdays);
   updatedates();
}); 

$('body .btn-submit').mousedown(function(e) {     
    mouse=1;
    if ($(this).parent().children('input').attr('checked')){
        $(this).parent().children('input').removeAttr('checked');
        numdays--;
        updatenum(numdays);
        $('body .btn-submit').on('mouseenter',function(){
            if ($(this).parent().children('input').attr('checked')){
                $(this).parent().children('input').removeAttr('checked');
                numdays--;
                updatenum(numdays);
            }
        });
    }
    else{
        $(this).parent().children('input').attr('checked', 'checked')
        numdays++;
        updatenum(numdays);
        $('body .btn-submit').on('mouseenter',function(){        
            if ((!$(this).parent().children('input').attr('checked'))&&(numdays>0)){
                $(this).parent().children('input').attr('checked', 'checked');
                numdays++;
                updatenum(numdays);                
            }
        });
    }
})  
    .click(function(e){
         e.preventDefault();
     });

function updatedates(){
    var curDate = 0;
    var line = 0;
    var numLine = 0;
    var i = 0;
    var $child;
    var curIndex;
    strDays = [];
    $('#calendar input').each(function( index ) {        
        if (!line){
            if ($(this).attr('checked')){
                curDate = formatDate(new Date ($(this).attr('cur-date')*1000));
                curDateVal = formatDateVal(new Date ($(this).attr('cur-date')*1000));
                line = 1;
                numLine++;
                curIndex = index;
            }
            else{
                
            }
        }
        else{
            if ($(this).attr('checked')){
                numLine++;
            }
            else{                        
                line = 0;
                endDate = new Date ($(this).attr('cur-date')*1000);
                endDate.setDate(endDate.getDate() - 1);
                var $el = $('<tr><td><input class="curDate" type="date" value="'+curDateVal+'"></td><td><input type="number" min="0" class="numLine" value="'+numLine+'"></td><td><input type="number" min="0" value="0" class="PVT"></td><td><input type="number" min="0" value="0" class="INV"></td><td><input type="number" min="0" value="0" class="OB"></td></tr>');
                $child = $('#table-all').children().eq(i);
                if ( $child.html()){
                    $('.curDate', $child).val(curDateVal);
                    $('.numLine', $child).val(numLine);
                    i++;                    
                    strDays.push({curDateVal:curDateVal, numLine:numLine, curIndex:curIndex });
                    
                }
                else{
                    
                    $('#table-all').append($el);       
                    i++;
                    strDays.push({curDateVal:curDateVal, numLine:numLine, curIndex:curIndex, PVT:0, INV:0, OB:0 });
                }
                numLine=0;   
            }
        }        
    });
    $child = $('#table-all').children().eq(i);
    while ($child.html()){
        $child.detach();
        $child = $('#table-all').children().eq(i);
    }    
}

function updateCalendar(){

}

function tableInputOn(){
    var PVT = 0;
    var INV = 0;
    var OB = 0;
    var numOldLine;
    var i=0;
    var numDopLine = 0;
    $('#table-all input').change(function( ){
        var index = $(this).parent().parent().index();
        var curIndex = +strDays[index].curIndex;
        numOldLine = +strDays[index].numLine;
        strDays[index].numLine = $(this).parent().parent().find('.numLine').val();
        PVT = $(this).parent().parent().find('.PVT').val();
        INV = $(this).parent().parent().find('.INV').val();
        OB = $(this).parent().parent().find('.OB').val();
        console.log(curIndex);
        console.log(numOldLine);
        console.log(strDays[index].numLine);
        numOldDopLine = +strDays[index].PVT + +strDays[index].INV + +strDays[index].OB;
        numDopLine = +PVT + +INV + +OB
        if ($(this).parent().index()==1){
            if (numOldLine < strDays[index].numLine){
                for (i = numOldLine; i<strDays[index].numLine; i++){
                    if (numDopLine>0){
                        $('#calendar input').eq(curIndex +numDopLine +i).attr('checked', 'checked').addClass('dop-days');
                        $('#calendar input').eq(curIndex +i).removeClass('dop-days');
                    }
                    else{
                        $('#calendar input').eq(curIndex +numDopLine +i).attr('checked', 'checked');
                    }                    
                } 
            }
            else {
                for (i = numOldLine; i>strDays[index].numLine; i--){
                    if (numDopLine>0){
                        $('#calendar input').eq(curIndex+numDopLine+i-1).removeAttr('checked').removeClass('dop-days');
                        $('#calendar input').eq(curIndex+i-1).addClass('dop-days');
                    }
                    else{
                        $('#calendar input').eq(curIndex+numDopLine+i-1).removeAttr('checked');
                    }   
                }   
            }
        }
        else if ($(this).parent().index()>1){
            if (numOldDopLine < numDopLine){
                for (i = numOldDopLine; i<numDopLine; i++){
                    $('#calendar input').eq(curIndex +numOldLine +i).attr('checked', 'checked').addClass('dop-days');
                    console.log(1);
                } 
            }  
            else {
                for (i = numOldDopLine; i>numDopLine; i--){
                    $('#calendar input').eq(curIndex+numOldLine+i-1).removeAttr('checked').removeClass('dop-days');
                }   
            }
        }
        strDays[index].PVT = PVT;
        strDays[index].INV = INV;
        strDays[index].OB = OB;
	console.log(strDays[index]);
});
}

function formatDate(date) {

  var dd = date.getDate();
  if (dd < 10) dd = '0' + dd;

  var mm = date.getMonth() + 1;
  if (mm < 10) mm = '0' + mm;

  var yy = date.getFullYear();

  return dd + '.' + mm + '.' + yy;
}

function formatDateVal(date) {

  var dd = date.getDate();
  if (dd < 10) dd = '0' + dd;

  var mm = date.getMonth() + 1;
  if (mm < 10) mm = '0' + mm;

  var yy = date.getFullYear();

  return yy + '-' + mm + '-' + dd;
}


function updatenum(n){
    $('#numdays').html('Выбрано дней: '+ n);
    $('#numdaysIn').val(n);
}


$(document).mouseup (function() {  
  $('body .btn-submit').off('mouseenter');
  if (mouse){
      mouse=0;
      updatedates();
      tableInputOn();
  }  
});
   

$(document).ready(function() {    
   updatenum(numdays);
   updatedates();
   tableInputOn();
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
