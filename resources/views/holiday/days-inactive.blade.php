@foreach ($arHolidays as $day)
    @if ($day===$j.'.'.$month)
        <td height="40px" class="month-{{$month}} holiday2">
            <div>{{$j}}</div>
        </td>
        @php
            $hol = 1;
        @endphp
        @break
    @endif
@endforeach
@if (!$hol)
    @if ($i==6 || $i==7)
        <td height="40px" class="month-{{$month}} holiday-{{$month%2}}">
            <div>{{$j}}</div>
        </td>
    @else
        <td height="40px" class="month-{{$month}}">
            <div>{{$j}}</div>
        </td>   
    @endif       
@else
    @php
        $hol = 0;
    @endphp
@endif