@php
    $weekday = mktime(0, 0, 0, $month, 1, $year);
    $weekday = getdate($weekday);
    $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));



    $i=1;
    $j=1;
    $end=0;
    $numdays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    if ($weekday['wday'] == 0)
    {
        $weekday['wday'] = 7;
    }
    $hol = 0;
    $months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
@endphp
<table cellspacing="0" cellpadding="0">
    <tr>

    </tr>
@if ($month % 4 == 1)
    <tr>
        @for ($i = 1; $i < 8; $i++)
            @if ($i==$weekday['wday'])
                @break
            @endif
            <td class="p-2"></td>
        @endfor
        @for (; $i < 8; $i++)
            @if ($today < mktime(0, 0, 0, $month, $j, $year))
                @include ('offHours.days')
            @else
                @include ('offHours.days-inactive')
            @endif
            @php
                $j++;
            @endphp
        @endfor
    @else
        @for ($i = 1; $i < 8; $i++)
            @if ($i==$weekday['wday'])
                @break
            @endif
        @endfor
        @for (; $i < 8; $i++)
            @php
                $j++;
            @endphp
        @endfor
    </tr>
@endif
@while (1)
<tr>
    @for ($i=1; $i < 8; $i++)
        @if ($j>$numdays)
            @php
                $end=1;
                $j=1;
            @endphp
        @endif
        @if ($end==1)
            @if ($month % 4 != 0)
                @if ($today < mktime(0, 0, 0, $month+1, $j, $year))
                    @include ('offHours.days',['month'=>$month+1])
                @else
                    @include ('offHours.days-inactive',['month'=>$month+1])
                @endif
                @php
                    $j++;
                @endphp
            @endif
        @else
            @if ($today < mktime(0, 0, 0, $month, $j, $year))
                @include ('offHours.days')
            @else
                @include ('offHours.days-inactive')
            @endif
            @php
                $j++;
            @endphp
        @endif
    @endfor
    @if ($end)
        @break
    @endif
</tr>
@endwhile
</tr>
</table>
