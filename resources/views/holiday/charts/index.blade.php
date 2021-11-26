@extends('app')


@section('content')


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                
            </div>
            <div class="col-2">
            </div>
                
            <div class="col-1">
            </div>
            <div class="col-2 text-center">
                
            </div>
            <div class="col-3 text-end">
                
            </div>  
            <div class="col-2 text-end">
                @include ('modules.menu')                    
            </div>            
        </div>        
    </div>

    <div class="card-body d-flex flex-wrap justify-content-center align-items-start" id="holiday">
                
    </div>
    <div class="scrolling-container">
            <div id="container"></div>
    </div>

</div>

@endsection


@push('styles')
<style>
#container {
    max-width: 1300px;
    margin: 1em auto;
}

.scrolling-container {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
</style>
    @include ('modules.theme')
@endpush

@push('beforescripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
@endpush
@push('scripts')
<script src="{{ asset('js/highcharts-gantt.src.js') }}"></script>
<script src="{{ asset('js/exporting.js') }}"></script>

<script>
function logout(){
    $.ajax({
        url: `{{ route('logout') }}`,
        data: {
          '_token': '{{ csrf_token() }}'
        },
        type: 'POST',
        success: function () {
         window.location.href="/";
        },
        error: function(){
         window.location.href="/";   
        }                
      });
}

var day = 1000 * 60 * 60 * 24,
    map = Highcharts.map,
    dateFormat = Highcharts.dateFormat,
    series,
    cars;

// Set to 00:00:00:000 today


cars = [];

var dateint;
var utc = new Date();
var data =[];
var days;
var dateto
@foreach ($users as $user)    
    @if (count ($user->holidaysYear(2022)))            
            @forelse ($user->holidaysYear(2022) as $holiday)
                dateint = new Date('{{$holiday->datefrom}}');
                dateto = new Date('{{$holiday->dateto}}');
                console.log (dateint);
                data.push({
                    name: '{{$user->name}}',
                    range:' с ' + (dateint.getUTCDate()+1) + '.' + (dateint.getMonth()+1) + ' по ' + dateto.getUTCDate() + '.' + (dateto.getMonth()+1),
                    start: dateint.getTime(),
                    end: dateint.getTime() + {{$holiday->days}}*day
                });                
            @empty    
            @endforelse
    @endif
@endforeach

// Parse car data into series.
series = [{
    name:'График отпусков',
    data:data,
    dataLabels: {
        enabled: true,
        format: '{point.range}',
        align: 'left',
        style: {
            cursor: 'default',
            pointerEvents: 'none'
        }
    }
}]



Highcharts.setOptions({
    lang: {
            loading: 'Загрузка...',
            months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            weekdays: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
            shortMonths: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
            exportButtonTitle: "Экспорт",
            printButtonTitle: "Печать",
            rangeSelectorFrom: "С",
            rangeSelectorTo: "По",
            rangeSelectorZoom: "Период",
            downloadPNG: 'Скачать PNG',
            downloadJPEG: 'Скачать JPEG',
            downloadPDF: 'Скачать PDF',
            downloadSVG: 'Скачать SVG',
            printChart: 'Напечатать график'   
        }        
});


Highcharts.dateFormats = {
        W: function (timestamp) {
        var date = new Date(timestamp);
        var firstDay = new Date(date.getFullYear(), 0, 1); 
        var day = firstDay.getDay() == 0 ? 7 : firstDay.getDay();
        var days = Math.floor((date.getTime() - firstDay)/86400000) + day; // day numbers from the first Monday of the year to current date
        return Math.ceil(days/7);
    },
}

Highcharts.ganttChart('container', {

    title: {
        text: 'Gantt Chart with Navigation'
    },

    yAxis: {
        uniqueNames: true
    },

    navigator: {
        enabled: true,
        liveRedraw: true,
        series: {
            type: 'gantt',
            pointPlacement: 0.5,
            pointPadding: 0.25
        },
        yAxis: {
            min: 0,
            max: 3,
            reversed: true,
            categories: []
        }
    },
    scrollbar: {
        enabled: true
    },
    rangeSelector: {
        enabled: true,
        selected: 0
    },
    xAxis: [{
        minTickInterval: 1000 * 60 * 60 * 24, // 1 day
        dateTimeLabelFormats: {
            
            week: {list: ['%W Неделя', '%W Нед.']},
            day: '%e',
        }
    },{
    minTickInterval: 1000 * 60 * 60 * 24, // 1 day
        dateTimeLabelFormats: {            
            week: {list: ['%B, %W Неделя', '%B, %W Нед.','%b, %W Нед.']},
            day: '%e',
        }
    }],
    series: series
});


</script>
@endpush
