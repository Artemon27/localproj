@php

@endphp
<table>
    <tr>
        <td class="wd-name p-2" width="40px">Дата</td>
        <td class="wd-name p-2" width="40px">Пропуск</td>
        <td class="wd-name p-2" width="40px">Помещение</td>
        <td class="wd-name p-2" width="40px">Телефон</td>
    </tr>
    <tbody id="table-all">
        @forelse ($dates as $date)
        <tr>
            <td><input class="curDate" type="date" name="data[{{$loop->index}}][date]" value="{{Substr($date->date,0,10)}}" readonly></td>
            <td><input type="text" size="5" name="data[{{$loop->index}}][prpsk]" value="{{$date->prpsk}}"></td>
            <td><input type="text" size="15" value="{{$date->room}}" name="data[{{$loop->index}}][room]"></td>
            <td><input type="text" size="15" value="{{$date->phone}}" name="data[{{$loop->index}}][phone]"></td>
            <td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>
