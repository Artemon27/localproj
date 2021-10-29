@php
    $currentDate = strtotime($j.'.'.$month.'.'.$year);
@endphp
@foreach ($arHolidays as $day)
    @if ($day===$j.'.'.$month)        
        @forelse ($dates as $key => $date)            
            @if ($date->datefromStr <= $currentDate)
                @if ($date->datetoStr >= $currentDate)
                    <td height="40px" class="month-{{$month}} holiday2">
                        <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : 'checked'}}>
                        <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                    </td> 
                @else
                    @php
                        unset($dates[$key])
                    @endphp
                    <td height="40px" class="month-{{$month}} holiday2">
                        <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                        <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                    </td> 
                @endif    
            @else
                <td height="40px" class="month-{{$month}} holiday2">
                    <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                    <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                </td> 
            @endif
            @break
        @empty
            <td height="40px" class="month-{{$month}} holiday2">
                <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
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
                    <td height="40px" class="month-{{$month}} holiday-{{$month%2}}">
                        <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : 'checked'}}>
                        <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                    </td> 
                @else
                    @php
                        unset($dates[$key])
                    @endphp
                    <td height="40px" class="month-{{$month}} holiday-{{$month%2}}">
                        <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                        <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                    </td> 
                @endif    
            @else
                <td height="40px" class="month-{{$month}} holiday-{{$month%2}}">
                    <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                    <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                </td> 
            @endif
            @break
        @empty
            <td height="40px" class="month-{{$month}} holiday-{{$month%2}}">
                <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
            </td>
        @endforelse
    @else
        @forelse ($dates as $key => $date)
            @if ($date->datefromStr <= $currentDate)
                @if ($date->datetoStr >= $currentDate)
                    <td height="40px" class="month-{{$month}}">
                        <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : 'checked'}}>
                        <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                    </td> 
                @else
                    @php
                        unset($dates[$key])
                    @endphp
                    <td height="40px" class="month-{{$month}}">
                        <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                        <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                    </td> 
                @endif    
            @else
                <td height="40px" class="month-{{$month}}">
                    <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                    <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
                </td> 
            @endif
            @break
        @empty
            <td height="40px" class="month-{{$month}}">
                <input type="checkbox" class="btn-check" cur-date="{{$currentDate}}" name="data[{{$currentDate}}]" autocomplete="off" {{old('data') ? (array_key_exists($currentDate, old('data')) ? 'checked' : '') : ''}}>
                <label class="btn-submit" for="data[{{$currentDate}}]">{{$j}}</label>
            </td>
        @endforelse
    @endif       
@else
    @php
        $hol = 0;
    @endphp
@endif