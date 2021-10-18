@foreach ($arHolidays as $day)
    @if ($day===$j.'.'.$month)
        <td height="40px" class="month-{{$month}} holiday2">
            <input type="checkbox" class="btn-check" id="check-{{$month.'.'.$j}}" autocomplete="off">
            <label class="btn-submit" for="check-{{$month.'.'.$j}}">{{$j}}</label>
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
            <input type="checkbox" class="btn-check" id="check-{{$month.'.'.$j}}" autocomplete="off">
            <label class="btn-submit" for="check-{{$month.'.'.$j}}">{{$j}}</label></td> 
        </td> 
    @else
        <td height="40px" class="month-{{$month}}">
            <input type="checkbox" class="btn-check" id="check-{{$month.'.'.$j}}" autocomplete="off">
            <label class="btn-submit" for="check-{{$month.'.'.$j}}">{{$j}}</label></td> 
        </td>   
    @endif       
@else
    @php
        $hol = 0;
    @endphp
@endif