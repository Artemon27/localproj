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
            @include ('holiday.table',['dates'=>$dates])
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
    $('body .dchange').each(function() {
        if ($(this).hasClass('dchecked')){
            $(this).removeClass('dchecked');
            numdays--;
        }
   });
   updatenum(numdays);
   updatedates();
}); 

$('body .dchange').mousedown(function(e) {     
    mouse=1;
    if ($(this).hasClass('dchecked')){
        $(this).removeClass('dchecked');
        numdays--;
        updatenum(numdays);
        $('body .dchange').on('mouseenter',function(){
            if (($(this).hasClass('dchecked'))&&(numdays>0)){
                $(this).removeClass('dchecked');
                numdays--;
                updatenum(numdays);
            }
        });
    }
    else{
        $(this).addClass('dchecked');
        numdays++;
        updatenum(numdays);
        $('body .dchange').on('mouseenter',function(){        
            if (!$(this).hasClass('dchecked')){
                $(this).addClass('dchecked');
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
    
    $('#calendar .dchange').each(function( index ) {        
        if (!line){
            if ($(this).hasClass('dchecked')){
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
            if ($(this).hasClass('dchecked')){
                numLine++;
            }
            else{                        
                line = 0;
                endDate = new Date ($(this).attr('cur-date')*1000);
                endDate.setDate(endDate.getDate() - 1);
                var $el = $('<tr><td><input class="curDate" type="date" name="data['+i+'][datefrom]" value="'+curDateVal+'" disabled></td><td><input type="number" min="0" class="numLine" name="data['+i+'][days]" value="'+numLine+'"></td><td><input type="number" min="0" value="0" name="data['+i+'][PVT]" class="PVT"></td><td><input type="number" min="0" value="0" name="data['+i+'][INV]" class="INV"></td><td><input type="number" min="0" value="0" name="data['+i+'][OB]" class="OB"></td></tr>');
                $child = $('#table-all').children().eq(i);
                if ( $child.html()){
                    $('.curDate', $child).val(curDateVal);
                    $('.numLine', $child).val(numLine);
                    strDays[i].curDateVal=curDateVal;
                    strDays[i].numLine=numLine;
                    strDays[i].curIndex=curIndex;
                    $('.PVT', $child).val(0);
                    $('.INV', $child).val(0);
                    $('.OB', $child).val(0);
                    strDays[i].PVT=0;
                    strDays[i].INV=0;
                    strDays[i].OB=0;
                    i++;               
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
        strDays.splice(i, 1);
    }    
}



function tableInputOn(){
    $('body input').off('change');
    var PVT = 0;
    var INV = 0;
    var OB = 0;
    var numOldLine;
    var numDopLine = 0;
    var numLine=0;
    $('#table-all input').change(function( ){
        var i=0;
        var index = $(this).parent().parent().index();
        var curIndex = +strDays[index].curIndex;
        numOldLine = +strDays[index].numLine;
        strDays[index].numLine = $(this).parent().parent().find('.numLine').val();
        PVT = $(this).parent().parent().find('.PVT').val();
        INV = $(this).parent().parent().find('.INV').val();
        OB = $(this).parent().parent().find('.OB').val();
        numOldDopLine = +strDays[index].PVT + +strDays[index].INV + +strDays[index].OB;
        numDopLine = +PVT + +INV + +OB
        if ($(this).parent().index()==1){
            if (numOldLine < strDays[index].numLine){
                for (i = numOldLine; i<strDays[index].numLine; i++){
                    if (numDopLine>0){                        
                        if (strDays[+index+1]){
                            if((+curIndex + +numDopLine +i+1)>=(strDays[+index+1].curIndex)){
                                strDays[index].numLine = +strDays[index].numLine + +strDays[+index+1].numLine;
                                numLine = PVT + +strDays[+index+1].PVT;
                                strDays.splice(index+1, 1);
                                $(this).parent().parent().find('.PVT').val(numLine).change();
                                $(this).parent().parent().find('.numLine').val(strDays[index].numLine);
                                $(this).parent().parent().parent().children().eq(index+1).detach();
                            }
                        } 
                        $('#calendar .dchange').eq(curIndex +numDopLine +i).removeClass('dchecked').addClass('dop-days');
                        $('#calendar .dchange').eq(curIndex +i).removeClass('dop-days').addClass('dchecked');
                    }
                    else{
                        if (strDays[+index+1]){
                            if((curIndex +i+1)>=(strDays[+index+1].curIndex)){
                                strDays[index].numLine = +strDays[index].numLine + +strDays[+index+1].numLine;
                                strDays.splice(index+1, 1);
                                $(this).parent().parent().find('.numLine').val(strDays[index].numLine);
                                $(this).parent().parent().parent().children().eq(index+1).detach();
                            }
                        }                        
                        $('#calendar .dchange').eq(curIndex +i).addClass('dchecked').removeClass('dop-days');
                    }                    
                } 
            }
            else {
                for (i = numOldLine; i>strDays[index].numLine; i--){
                    if (numDopLine>0){
                        $('#calendar .dchange').eq(curIndex+numDopLine+i-1).removeClass('dchecked dop-days');
                        $('#calendar .dchange').eq(curIndex+i-1).removeClass('dchecked').addClass('dop-days');
                    }
                    else{
                        $('#calendar .dchange').eq(curIndex+numDopLine+i-1).removeClass('dchecked');
                    }   
                }   
            }
        }
        else if ($(this).parent().index()>1){
        console.log(numOldDopLine);
        console.log(numDopLine);
            if (numOldDopLine < numDopLine){
                for (i = numOldDopLine; i<numDopLine; i++){
                    $('#calendar .dchange').eq(curIndex +numOldLine +i).removeClass('dchecked').addClass('dop-days');
                    if (strDays[+index+1]){
                        if((curIndex + +numOldLine +i+1)>=(strDays[+index+1].curIndex)){
                            numLine = +strDays[index].numLine + +strDays[+index+1].numLine;
                            strDays.splice(index+1, 1);
                            $(this).parent().parent().find('.numLine').val(numLine).change();
                            $(this).parent().parent().parent().children().eq(index+1).detach();
                            continue;
                        }
                    }                    
                    console.log(1);
                } 
            }  
            else {
                for (i = numOldDopLine; i>numDopLine; i--){
                    $('#calendar .dchange').eq(curIndex+numOldLine+i-1).removeClass('dop-days');
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
  $('body .dchange').off('mouseenter');
  if (mouse){
      mouse=0;
      updatedates();
      tableInputOn();
      $('#calendar .dop-days').removeClass('dop-days');
  }  
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
