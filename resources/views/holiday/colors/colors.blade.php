@php
   $colnames=['odd' => 'нечетный месяц','even' =>  'четный месяц','odd_holi' =>  'нечетный-выходные','even_holi' =>  'четный-выходные', 
   'odd_color' => 'нечетный-шрифт','even_color' =>  'четный-шрифт','odd_holi_color' =>  'нечетный-выходные-шрифт','even_holi_color' =>  'четный-выходные-шрифт',
   'base_color' => 'цвет шрифтов','background' =>  'цвет фона','chosen_color' =>  'цвет выбранных','chosen_dop_color' =>  'цвет доп.выбранных', 'carousel_controls' =>  'цвет стрелок']
@endphp
<form action="{{ route('holiday.addcolors') }}" method="post">
    @csrf
    <table id='table-colors'>
        <tr>
            <td class="wd-name p-2" >Название</td>            
            <td class="wd-name p-2" >Цвет</td>
        </tr>
        <tbody id="tableColors">        
            @foreach ($colnames as $coltitle => $colname)
            <tr>
                <td><div class="colColor text-end">{{$colname}}</div></td>
                <td><input id="{{$coltitle}}" class="changeColor" type="color" name="{{$coltitle}}" ></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col"><button href="" class="btn btn-btn btn-sm btn-outline-primary">Сохранить</button></div>
</form>


@push('scripts')
<script>
    
$(document).mouseup (function() {  
    $('.dchecked').css('background-color', $('#chosen_color').val());
    $('.dop-days').css('background-color', $('#chosen_dop_color').val());
});

$('.changeColor').on('input',function() {
    switch ($(this).attr('name')){
        case 'odd':
            $('.month-1, .month-3, .month-5, .month-7, .month-9, .month-11').css('background-color', $(this).val());
            $('.holiday-1').css('background-color', $('#odd_holi').val());
            $('.dchecked').css('background-color', $('#chosen_color').val());
            $('.dop-days').css('background-color', $('#chosen_dop_color').val());
            break;
        case 'even':
            $('.month-2, .month-4, .month-6, .month-8, .month-10, .month-12').css('background-color', $(this).val());
            $('.holiday-0').css('background-color', $('#even_holi').val());
            $('.dchecked').css('background-color', $('#chosen_color').val());
            $('.dop-days').css('background-color', $('#chosen_dop_color').val());
            break;
        case 'odd_holi':
            $('.holiday-1').css('background-color', $(this).val());
            $('.dchecked').css('background-color', $('#chosen_color').val());
            $('.dop-days').css('background-color', $('#chosen_dop_color').val());
            break;
        case 'even_holi':
            $('.holiday-0').css('background-color', $(this).val());
            $('.dchecked').css('background-color', $('#chosen_color').val());
            $('.dop-days').css('background-color', $('#chosen_dop_color').val());
            break;
        case 'odd_color':
            $('.month-1, .month-3, .month-5, .month-7, .month-9, .month-11').css('color', $(this).val());
            $('.holiday-1').css('color', $('#odd_holi_color').val());
            break;
        case 'even_color':
            $('.month-2, .month-4, .month-6, .month-8, .month-10, .month-12').css('color', $(this).val());
            $('.holiday-0').css('color', $('#even_holi_color').val());
            break;
        case 'odd_holi_color':
            $('.holiday-1').css('color', $(this).val());
            break;
        case 'even_holi_color':
            $('.holiday-0').css('color', $(this).val());
            break;
        case 'base_color':
            $('body, .month-name').css('color', $(this).val());
            $('.month-1, .month-3, .month-5, .month-7, .month-9, .month-11').css('color', $('#odd_holi').val());
            $('.holiday-1').css('color', $('#odd_holi_color').val());
            $('.month-2, .month-4, .month-6, .month-8, .month-10, .month-12').css('color', $('#even_holi').val());
            $('.holiday-0').css('color', $('#even_holi_color').val());
            break;
        case 'background':
            $('.card').css('background-color', $(this).val());
            break;
        case 'chosen_color':
            $('.dchecked').css('background-color', $(this).val());
            break;
        case 'chosen_dop_color':
            $('.dop-days').css('background-color', $(this).val());
            break;
        case 'carousel_controls':
            $('.carousel-control-prev-icon, .carousel-control-next-icon').css('background-color', $(this).val());
            break;            
    }  
});
baseChange();

function baseChange(){
        $('#odd').val('{{$color->odd ?? '#293B3C'}}');
        $('#even').val('{{$color->even ?? '#1f2040'}}');
        $('#odd_holi').val('{{$color->odd_holi ?? '#436264'}}');
        $('#even_holi').val('{{$color->even_holi ?? '#2e2f62'}}');
        $('#odd_color').val('{{$color->odd_color ?? '#ffffff'}}');
        $('#even_color').val('{{$color->even_color ?? '#ffffff'}}');
        $('#odd_holi_color').val('{{$color->odd_holi_color ?? '#e3cfac'}}');
        $('#even_holi_color').val('{{$color->even_holi_color ?? '#e3cfac'}}');
        $('#base_color').val('{{$color->base_color ?? '#ffffff'}}');
        $('#background').val('{{$color->background ?? '#150505'}}');
        $('#chosen_color').val('{{$color->chosen_color ?? '#1b5c75'}}');
        $('#chosen_dop_color').val('{{$color->chosen_dop_color ?? '#257899'}}');
        $('#carousel_controls').val('{{$color->carousel_controls ?? '#150505'}}');
       
        $('.month-1, .month-3, .month-5, .month-7, .month-9, .month-11').css('background-color', $('#odd').val());
        $('.holiday-1').css('background-color', $('#odd_holi').val());
        $('.month-2, .month-4, .month-6, .month-8, .month-10, .month-12').css('background-color', $('#even').val());
        $('.holiday-0').css('background-color', $('#even_holi').val());
        $('.dchecked').css('background-color', $('#chosen_color').val());
        $('.dop-days').css('background-color', $('#chosen_dop_color').val());
        $('body, .month-name').css('color', $('#base_color').val());
        $('.month-1, .month-3, .month-5, .month-7, .month-9, .month-11').css('color', $('#odd_color').val());
        $('.holiday-1').css('color', $('#odd_holi_color').val());
        $('.month-2, .month-4, .month-6, .month-8, .month-10, .month-12').css('color', $('#even_color').val());
        $('.holiday-0').css('color', $('#even_holi_color').val());
        $('.card').css('background-color', $('#background').val());
        $('.carousel-control-prev-icon, .carousel-control-next-icon').css('background-color', $('#carousel_controls').val());
}
</script>
@endpush