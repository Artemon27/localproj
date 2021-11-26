@php

@endphp
<table>
    <tr>
        <td class="wd-name p-2" style="width:162px">Дата</td>
        <td class="wd-name p-2" style="width:81px">Пропуск</td>
        <td class="wd-name p-2" style="width:114px">Помещение</td>
        <td class="wd-name p-2" style="width:114px">Телефон</td>
        <td style="width:72px"></td>
    </tr>
    <tbody id="table-all">
        @forelse ($dates as $date)
        <tr>
            <td><input class="curDate" type="date" name="data[{{$loop->index}}][date]" value="{{Substr($date->date,0,10)}}" readonly></td>
            <td><input type="text" size="5" name="data[{{$loop->index}}][prpsk]" value="{{$date->prpsk}}"></td>
            <td><input type="text" size="10" value="{{$date->room}}" name="data[{{$loop->index}}][room]"></td>
            <td><input type="text" size="10" value="{{$date->phone}}" name="data[{{$loop->index}}][phone]"></td>
            <td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>
