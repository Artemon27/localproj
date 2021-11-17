@php
    $currentDate = strtotime($j.'.'.$month.'.'.$year);
@endphp
@isset ($arHolidays)
    @foreach ($arHolidays as $day)
        @if ($day===$j.'.'.$month)
            <td width="40px" height="40px" class="month-{{$month}} holiday2 dblock" cur-date="{{$currentDate}}">
                {{$j}}
            </td>
            @php
                $hol = 1;
            @endphp
            @break
        @endif
    @endforeach
@endisset
@if (!$hol)
    @if ($i==6 || $i==7)
        <td width="40px" height="40px" class="month-{{$month}} holiday-{{$month%2}} dblock" cur-date="{{$currentDate}}">
            {{$j}}
        </td>
    @else
        <td width="40px" height="40px" class="month-{{$month}} dblock" cur-date="{{$currentDate}}">
            {{$j}}
        </td>   
    @endif       
@else
    @php
        $hol = 0;
    @endphp
@endif