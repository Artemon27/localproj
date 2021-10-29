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


<form action="{{ route('admin.holidaydays.store') }}" method="post">
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
        <div class="card-body" id="holiday">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">    
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
                            <div class="d-flex flex-wrap justify-content-center">
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
                                                @include ('admin.holidays.calendar-templ',['month'=>$n,'year'=>$curyear])
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
        </div>
    </div>
</form>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/calendar.css') }}">
@endpush


@push('scripts')
<script>
$('#btn-off').click(function(){
    $('body input:checkbox').each(function() {
        if ($(this).attr('checked')){
            $(this).removeAttr('checked');
        }
   });
}); 

$('body .btn-submit').mousedown(function(e) {     
    if ($(this).parent().children('input').attr('checked')){
        $(this).parent().children('input').removeAttr('checked');
        $('body .btn-submit').on('mouseenter',function(){
            if ($(this).parent().children('input').attr('checked')){
                $(this).parent().children('input').removeAttr('checked');
            }
        });
    }
    else{
        $(this).parent().children('input').attr('checked', 'checked')
        $('body .btn-submit').on('mouseenter',function(){        
            if ((!$(this).parent().children('input').attr('checked'))&&(numdays>0)){
                $(this).parent().children('input').attr('checked', 'checked');
            }
        });
    }
})  
    .click(function(e){
         e.preventDefault();
     });

$(document).mouseup (function() {  
  $('body .btn-submit').off('mouseenter');
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
