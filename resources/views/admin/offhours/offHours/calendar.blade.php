@php
    $weekday = mktime(0, 0, 0, $month, 1, $year);
    $weekday = getdate($weekday);
    $today  = mktime(date("H")+3, date("i"), date("s"), date("m")  , date("d"), date("Y"));
    $today_date  = strtotime(date("d").'.'.date("m").'.'.date("Y"));

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
    <tr>
        @for ($i = 1; $i < 8; $i++)
            @if ($i==$weekday['wday'])
                @break
            @endif
            <td class="p-2"></td>
        @endfor
        @for (; $i < 8; $i++)
            @if ($today < mktime(9, 30, 0, $month, $j, $year))
                @if(($i==6 && $today >= mktime(9, 30, 0, $month, $j-1, $year)) || ($i==7 && $today >= mktime(9, 30, 0, $month, $j-2, $year)))
                    @include ('offHours.days-inactive')
                @else
                    @include ('offHours.days')
                @endif
            @else
                @include ('offHours.days-inactive')
            @endif
            @php
                $j++;
            @endphp
        @endfor
    </tr>
@while (1)
<tr>
    @for ($i=1; $i < 8; $i++)
        @if ($j>$numdays)
            @php
                $end=1;
                $j=1;
            @endphp
        @endif
        @if ($end!=1)
            @if ($today < mktime(9, 30, 0, $month, $j, $year))
                @if(($i==6 && $today >= mktime(9, 30, 0, $month, $j-1, $year)) || ($i==7 && $today >= mktime(9, 30, 0, $month, $j-2, $year)))
                    @include ('offHours.days-inactive')
                @else
                    @include ('offHours.days')
                @endif
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
