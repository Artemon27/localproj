<table id='table-dates' width="410px">
    <tr>
        <td class="wd-name p-2" width="122px">Начало</td>            
        <td class="wd-name p-2" width="54px">Дней</td>
        <td class="wd-name p-2" width="54px">ПВТ</td>
        <td class="wd-name p-2" width="54px">ИНВ</td>
        <td class="wd-name p-2" width="54px">ОБ</td>
    </tr>
    <tbody id="table-incative">        
        @forelse ($oldDates as $date)
        <tr>
            <td class="curDate" value="{{Substr($date->datefrom,0,10)}}">{{date('d.m.Y',strtotime($date->datefrom))}}</td>
            <td class="numLine">{{$date->days}}</td>
            <td class="PVT">{{$date->PVT}}</td>
            <td class="INV">{{$date->INV}}</td>
            <td class="OB">{{$date->OB}}</td>
            <td></td>
        </tr>
        @empty
        <tr class="empty">
            <td colspan="10"><h5>Выделите даты отпуска на календаре</h5></td>
        </tr>
        @endforelse     
    </tbody>
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