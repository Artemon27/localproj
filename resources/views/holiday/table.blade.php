@php
    
@endphp
<table>
    <tr>
        <td class="wd-name p-2" width="40px">Начало</td>            
        <td class="wd-name p-2" width="40px">Дней</td>
        <td class="wd-name p-2" width="40px">ПВТ</td>
        <td class="wd-name p-2" width="40px">ИНВ</td>
        <td class="wd-name p-2" width="40px">ОБ</td>
    </tr>
    <tbody id="table-all">        
        @forelse ($dates as $date)
        <tr>
            <td><input class="curDate" type="date" name="data[{{$loop->index}}][datefrom]" value="{{Substr($date->datefrom,0,10)}}" readonly></td>
            <td><input type="number" min="0" class="numLine" name="data[{{$loop->index}}][days]" value="{{$date->days}}"></td>
            <td><input type="number" min="0" value="{{$date->PVT}}" name="data[{{$loop->index}}][PVT]" class="PVT"></td>
            <td><input type="number" min="0" value="{{$date->INV}}" name="data[{{$loop->index}}][INV]" class="INV"></td>
            <td><input type="number" min="0" value="{{$date->OB}}" name="data[{{$loop->index}}][OB]" class="OB"></td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>