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
            <td><input class="curDate" type="date" name="data['{{$loop->iteration}}'][datefrom]" value="{{$date->datefrom}}" disabled></td>
            <td><input type="number" min="0" class="numLine" name="data['{{$loop->iteration}}'][days]" value="{{$date->days}}"></td>
            <td><input type="number" min="0" value="{{$date->PVT}}" name="data['{{$loop->iteration}}'][PVT]" class="PVT"></td>
            <td><input type="number" min="0" value="{{$date->INV}}" name="data['{{$loop->iteration}}'][INV]" class="INV"></td>
            <td><input type="number" min="0" value="{{$date->OB}}" name="data['{{$loop->iteration}}'][OB]" class="OB"></td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>