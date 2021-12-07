@php
    $currentDate = strtotime($j.'.'.$month.'.'.$year);
    $value = 0;
@endphp
@foreach ($times as $time)
    @if ($currentDate == strtotime($time['date']))
      @php
        $value = $time['time']
      @endphp
    @endif
@endforeach
@isset ($arHolidays)
    @foreach ($arHolidays as $day)
        @if ($day===$j.'.'.$month)
            <td width="150px" height="120px" class="h4 month-{{$month}} holiday2 dchange" cur-date="{{$currentDate}}">
                <div>{{$j}}</div>
            @if ($value != 0)
              <div><input value="{{$value}} ч." name="time[{{$year}}][{{$month}}][{{$j}}]" class="time" placeholder="ч"></div></td>
            @else
              <div><input value="" name="time[{{$year}}][{{$month}}][{{$j}}]" class="time" placeholder="ч"></div></td>
            @endif
            @php
                $hol = 1;
            @endphp
            @break
        @endif
    @endforeach
@endisset
@if (!$hol)
    @if ($i==6 || $i==7)
        <td width="150px" height="120px" class="h4 month-{{$month}} holiday-{{$month%2}} dchange" cur-date="{{$currentDate}}">
            <div>{{$j}}</div>
            @if ($value != 0)
              <div><input value="{{$value}} ч." name="time[{{$year}}][{{$month}}][{{$j}}]" class="time" placeholder="ч"></div></td>
            @else
              <div><input value="" name="time[{{$year}}][{{$month}}][{{$j}}]" class="time" placeholder="ч"></div></td>
            @endif
    @else
        <td width="150px" height="120px" class="h4 month-{{$month}} dchange" cur-date="{{$currentDate}}">
            <div>{{$j}}</div>
            @if ($value != 0)
              <div><input value="{{$value}} ч." name="time[{{$year}}][{{$month}}][{{$j}}]" class="time" placeholder="ч"></div></td>
            @else
              <div><input value="" name="time[{{$year}}][{{$month}}][{{$j}}]" class="time" placeholder="ч"></div></td>
            @endif
    @endif
@else
    @php
        $hol = 0;
    @endphp
@endif
