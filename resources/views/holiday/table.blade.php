<table id='table-dates'>
    <tr>
        <td class="wd-name p-2" width="40px">Начало</td>            
        <td class="wd-name p-2" width="40px">Дней</td>
        <td class="wd-name p-2" width="40px">ПВТ</td>
        <td class="wd-name p-2" width="40px">ИНВ</td>
        <td class="wd-name p-2" width="40px">ОБ</td>
    </tr>
    <tbody id="table-all">        
        @if (old('data')!=null)
            @forelse (old('data') as $date)
            <tr>
                <td><input class="curDate" type="date" name="data[{{$loop->index}}][datefrom]" value="{{$date['datefrom']}}" readonly></td>
                <td><input type="number" min="0" class="numLine" name="data[{{$loop->index}}][days]" value="{{$date['days']}}"></td>
                <td><input type="number" min="0" value="{{$date['PVT']}}" name="data[{{$loop->index}}][PVT]" class="PVT"></td>
                <td><input type="number" min="0" value="{{$date['INV']}}" name="data[{{$loop->index}}][INV]" class="INV"></td>
                <td><input type="number" min="0" value="{{$date['OB']}}" name="data[{{$loop->index}}][OB]" class="OB"></td>
                <td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td>
            </tr>
            @empty
            @endforelse        
        @else
            @forelse ($dates as $date)
            <tr>
                <td><input class="curDate" type="date" name="data[{{$loop->index}}][datefrom]" value="{{Substr($date->datefrom,0,10)}}" readonly></td>
                <td><input type="number" min="0" class="numLine" name="data[{{$loop->index}}][days]" value="{{$date->days}}"></td>
                <td><input type="number" min="0" value="{{$date->PVT}}" name="data[{{$loop->index}}][PVT]" class="PVT"></td>
                <td><input type="number" min="0" value="{{$date->INV}}" name="data[{{$loop->index}}][INV]" class="INV"></td>
                <td><input type="number" min="0" value="{{$date->OB}}" name="data[{{$loop->index}}][OB]" class="OB"></td>
                <td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td>
            </tr>
            @empty
            <tr class="empty">
                <td colspan="10"><h5>Выделите даты отпуска на календаре</h5></td>
            </tr>
            @endforelse        
        @endif
    </tbody>
</table>