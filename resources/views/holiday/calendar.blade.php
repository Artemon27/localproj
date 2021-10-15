@php
    $weekday = mktime(0, 0, 0, $month, 1, 2022);
    $weekday = getdate($weekday);
    $tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
    $tomorrow = getdate($tomorrow);
    $i=1;
    $j=1;
    $end=0;
    $numdays = cal_days_in_month(CAL_GREGORIAN, $month, 2022);
    if ($weekday['wday'] == 0) 
    {
        $weekday['wday'] = 7;
    }    
    $hol = 0;
@endphp
@if ($month % 4 == 1)         
    <tr>
        @for ($i = 1; $i < 8; $i++)  
            @if ($i==$weekday['wday'])
                @break                    
            @endif    
            <td class="p-2"></td>
        @endfor
        @for (; $i < 8; $i++)  
            @foreach ($arHolidays as $day)
                @if ($day===$j.'.'.$month)
                    <td class="p-2 month-{{$month}} holiday2">{{$j++}}</td> 
                    @php
                        $hol = 1;
                    @endphp
                    @break
                @endif
            @endforeach
            @if (!$hol)
                @if ($i==6 || $i==7)
                    <td class="p-2 month-{{$month}} holiday-{{$month%2}}">{{$j++}}</td> 
                @else
                    <td class="p-2 month-{{$month}}">{{$j++}}</td>   
                @endif       
            @else
                @php
                    $hol = 0;
                @endphp
            @endif
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
                @foreach ($arHolidays as $day)
                    @if ($day===$j.'.'.$month+1)
                        <td class="p-2 month-{{$month+1}} holiday2">{{$j++}}</td> 
                        @php
                            $hol = 1;
                        @endphp
                        @break
                    @endif
                @endforeach
                @if (!$hol)
                    @if ($i==6 || $i==7)
                        <td class="p-2 month-{{$month+1}} holiday-{{($month+1)%2}}">{{$j++}}</td> 
                    @else
                        <td class="p-2 month-{{$month+1}}">{{$j++}}</td>   
                    @endif       
                @else
                    @php
                        $hol = 0;
                    @endphp
                @endif    
            @endif
        @else
            @foreach ($arHolidays as $day)
                @if ($day===$j.'.'.$month)
                    <td class="p-2 month-{{$month}} holiday2">{{$j++}}</td> 
                    @php
                        $hol = 1;
                    @endphp
                    @break
                @endif
            @endforeach
            @if (!$hol)
                @if ($i==6 || $i==7)
                    <td class="p-2 month-{{$month}} holiday-{{$month%2}}">{{$j++}}</td> 
                @else
                    <td class="p-2 month-{{$month}}">{{$j++}}</td>   
                @endif                      
            @else
                @php
                    $hol = 0;
                @endphp
            @endif
        @endif                
    @endfor
    @if ($end)
        @break
    @endif
</tr>
@endwhile
</tr>
