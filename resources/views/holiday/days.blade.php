@php
    $currentDate = strtotime($j.'.'.$month.'.'.$year);
@endphp
@foreach ($arHolidays as $day)
    @if ($day===$j.'.'.$month)        
        <td height="40px" class="month-{{$month}} holiday2 dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}"  cur-date="{{$currentDate}}">
            {{$j}}
        </td>
        @php
            $hol = 1;
        @endphp
        @break
    @endif
@endforeach
@if (!$hol)
    @if ($i==6 || $i==7)        
        <td height="40px" class="month-{{$month}} holiday-{{$month%2}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
            {{$j}}
        </td>
    @else        
        <td height="40px" class="month-{{$month}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
            {{$j}}
        </td>
    @endif       
@else
    @php
        $hol = 0;
    @endphp
@endif