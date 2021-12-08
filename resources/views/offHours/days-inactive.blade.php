@php
    $currentDate = strtotime($j.'.'.$month.'.'.$year);
@endphp
@isset ($arHolidays)
    @foreach ($arHolidays as $day)
        @if ($day===$j.'.'.$month)
            <td width="90px" height="90px" class="h4 month-{{$month}} holiday2 celldate" cur-date="{{$currentDate}}">
                <div></div>
                <div>{{$j}}</div>
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
        <td width="90px" height="90px" class="h4 month-{{$month}} holiday-{{$month%2}} celldate" cur-date="{{$currentDate}}">
            <div></div>
            <div>{{$j}}</div>
        </td>
    @else
        <td width="90px" height="90px" class="h4 month-{{$month}} celldate" cur-date="{{$currentDate}}">
            <div></div>
            <div>{{$j}}</div>
        </td>
    @endif
@else
    @php
        $hol = 0;
    @endphp
@endif
