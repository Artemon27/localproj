@php
  $today  = mktime(date("H")+3, date("i"), date("s"), date("m")  , date("d"), date("Y"));
  $mondey=$today;
  $endstr= "09:30:00";
@endphp
@for ($j = (int)date('w',$today); $j > 1; $j--)
  @php
      $mondey=$mondey-(24*60*60);
  @endphp
@endfor
@php
    $mondey=$mondey-(24*60*60);
@endphp

<div class="carousel-item active">
<table>
    <tr>
        <td class="wd-name p-2" style="width:162px">Дата</td>
        <td class="wd-name p-2" style="width:81px">Пропуск</td>
        <td class="wd-name p-2" style="width:114px">Помещение</td>
        <td class="wd-name p-2" style="width:114px">Телефон</td>
        <td style="width:72px"></td>
    </tr>
    <tbody class="table-all">

        @forelse ($dates as $key=>$date)
            @if($mondey<=strtotime(substr($date->date,0,10).$endstr))
              <tr>
            @else
              <tr class='d-none'>
            @endif
            @if($today<=strtotime(substr($date->date,0,10).$endstr))
            <td><input class="curDate" type="date" name="data[{{$loop->index}}][date]" value="{{Substr($date->date,0,10)}}" readonly></td>
            <td><input type="text" size="5" name="data[{{$loop->index}}][prpsk]" value="{{$date->prpsk}}"></td>
            <td><input type="text" size="10" value="{{$date->room}}" name="data[{{$loop->index}}][room]"></td>
            <td><input type="text" size="10" value="{{$date->phone}}" name="data[{{$loop->index}}][phone]"></td>
            <td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td>
            @else
            <td><input class="curDate" type="date" name="data[{{$loop->index}}][date]" value="{{Substr($date->date,0,10)}}" readonly></td>
            <td><input type="text" size="5" name="data[{{$loop->index}}][prpsk]" value="{{$date->prpsk}}" readonly></td>
            <td><input type="text" size="10" value="{{$date->room}}" name="data[{{$loop->index}}][room]" readonly></td>
            <td><input type="text" size="10" value="{{$date->phone}}" name="data[{{$loop->index}}][phone]" readonly></td>
            @endif
            </tr>
            @if(isset($dates[$key+1]) &&
              (int)date('W',strtotime(substr($date->date,0,10).$endstr))!=(int)date('W',strtotime(substr($dates[$key+1]->date,0,10).$endstr)))
            </tbody>
            </table>
            </div>
            <div class="carousel-item">
              <table>
                <tr>
                    <td class="wd-name p-2" style="width:162px">Дата</td>
                    <td class="wd-name p-2" style="width:81px">Пропуск</td>
                    <td class="wd-name p-2" style="width:114px">Помещение</td>
                    <td class="wd-name p-2" style="width:114px">Телефон</td>
                    <td style="width:72px"></td>
                </tr>
                <tbody class="table-all">
            @endif
          @empty
        @endforelse
    </tbody>
</table>
</div>
