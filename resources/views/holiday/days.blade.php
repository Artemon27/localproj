@php
    $currentDate = strtotime($j.'.'.$month.'.'.$year);
@endphp
@foreach ($arHolidays as $day)
    @if ($day===$j.'.'.$month)        
        @forelse ($dates as $key => $date)            
            @if ($date->datefromStr <= $currentDate)
                @if ($date->datetoStr >= $currentDate)
                    <td height="40px" class="month-{{$month}} holiday2 dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : 'dchecked'}}"  cur-date="{{$currentDate}}">
                        {{$j}}
                    </td> 
                @else
                    @php
                        unset($dates[$key])
                    @endphp
                    <td height="40px" class="month-{{$month}} holiday2 dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}"  cur-date="{{$currentDate}}">
                        {{$j}}
                    </td> 
                @endif    
            @else
                <td height="40px" class="month-{{$month}} holiday2 dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}"  cur-date="{{$currentDate}}">
                    {{$j}}
                </td> 
            @endif
            @break
        @empty
            <td height="40px" class="month-{{$month}} holiday2 dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}"  cur-date="{{$currentDate}}">
                {{$j}}
            </td>
        @endforelse 
        @php
            $hol = 1;
        @endphp
        @break
    @endif
@endforeach
@if (!$hol)
    @if ($i==6 || $i==7)
        @forelse ($dates as $key => $date)
            @if ($date->datefromStr <= $currentDate)
                @if ($date->datetoStr >= $currentDate)
                    <td height="40px" class="month-{{$month}} holiday-{{$month%2}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : 'dchecked'}}" cur-date="{{$currentDate}}">
                        {{$j}}
                    </td> 
                @else
                    @php
                        unset($dates[$key])
                    @endphp
                    <td height="40px" class="month-{{$month}} holiday-{{$month%2}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
                        {{$j}}
                    </td> 
                @endif    
            @else
                <td height="40px" class="month-{{$month}} holiday-{{$month%2}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
                    {{$j}}
                </td> 
            @endif
            @break
        @empty
            <td height="40px" class="month-{{$month}} holiday-{{$month%2}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
                {{$j}}
            </td>
        @endforelse
    @else
        @forelse ($dates as $key => $date)
            @if ($date->datefromStr <= $currentDate)
                @if ($date->datetoStr >= $currentDate)
                    <td height="40px" class="month-{{$month}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : 'dchecked'}}" cur-date="{{$currentDate}}">
                        {{$j}}
                    </td> 
                @else
                    @php
                        unset($dates[$key])
                    @endphp
                    <td height="40px" class="month-{{$month}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
                        {{$j}}
                    </td> 
                @endif    
            @else
                <td height="40px" class="month-{{$month}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
                    {{$j}}
                </td> 
            @endif
            @break
        @empty
            <td height="40px" class="month-{{$month}} dchange {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'dchecked' : '') : ''}}" cur-date="{{$currentDate}}">
                {{$j}}
            </td>
        @endforelse
    @endif       
@else
    @php
        $hol = 0;
    @endphp
@endif