var mouse=0;
var strDays = [];
today = new Date ()
today = today.getTime()
endday = today+7*24*60*60*1000

//Кнопка очистки (очищает календарь)
$('#btn-off').click(function(){//**********************************************************
    $('body .dchange').each(function() {
        if ($(this).find('div:first-child').hasClass('d-block')){
            $(this).find('div:first-child').removeClass().addClass('d-none');
        }
   });
   updatenum();
   console.log($('.table-all tr'));
   $('.table-all tr').each(function( index ) {
       $(this).remove();
   });
   while($('#carouselExampleControls2 .carousel-item').length !=1){
     $('#carouselExampleControls2 .carousel-item:last').remove();
   }
});

//Клик по календарю (выделяет или снимает выделение)
$('body .dchange').mousedown(function(e) {//*************************************************
    mouse=1;
    if ($(this).find('div:first-child').hasClass('d-block')){
        $(this).find('div:first-child').removeClass().addClass('d-none');
        updatenum();
        updatedates();
        $('body .dchange').on('mouseenter',function(){
            if ($(this).find('div:first-child').hasClass('d-block')){
                $(this).find('div:first-child').removeClass().addClass('d-none');
                console.log('dsf');
                updatenum();
            }
        });
    }else{
        $(this).find('div:first-child').removeClass().addClass('d-block');
        updatenum();
        updatedates();
        $('body .dchange').on('mouseenter',function(){
            if ($(this).find('div:first-child').hasClass('d-none')){
                $(this).find('div:first-child').removeClass().addClass('d-block');
                updatenum();
            }
        });
    }
})
    .click(function(e){
         e.preventDefault();
     });


//Обновляет данные в таблице по рисованному календарю
function updatedates(){ //************************************************************
    var i = 0;
    $('.table-all tr').each(function( index ) {
      if(index>=i){
        $(this).remove();
      }
    });
    while($('#carouselExampleControls2 .carousel-item').length !=1){
      $('#carouselExampleControls2 .carousel-item:last').remove();
    }
    $('#carouselExampleControls2 .carousel-item').addClass('active')
    $('#calendar .dchange').each(function( index ) {
      if ($(this).hasClass('dchecked') || $(this).find('div:first-child').hasClass('d-block')){
        timestamp = new Date ($(this).attr('cur-date')*1000);
        curDateVal = formatDateVal(timestamp);
        curIndex = index;
        a=0
        $('.table-all:last tr .curDate').each(function( index ) {
          if(curDateVal == $('.table-all:last tr .curDate')[index].value)
            a=1
        });
        if(a!=1){

           var el = $('<tr><td><input class="curDate" type="date" name="data['+i+'][date]" value="'+curDateVal+'" readonly></td><td><input type="text" size="5" class="numLine" name="data['+i+'][prpsk]" value="'+prpsk+'"></td><td><input type="text" size="10" name="data['+i+'][room]" value="'+room+'"></td><td><input type="text" size="10" name="data['+i+'][phone]" value="'+phone+'"></td><td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td></tr>');
           delDates($('.del_dates', $(el)));
           if($('.carousel-item:last .table-all tr').length>=7){
             var el2 = $('<div class="carousel-item"><table><tr><td class="wd-name p-2" style="width:162px">Дата</td><td class="wd-name p-2" style="width:81px">Пропуск</td><td class="wd-name p-2" style="width:114px">Помещение</td><td class="wd-name p-2" style="width:114px">Телефон</td><td style="width:72px"></td></tr><tbody class="table-all"></tbody></table></div>')
             $('#carouselExampleControls2 .carousel-inner').append(el2);
             $('.carousel-item:last .table-all').append(el);
           }else{
             $('.carousel-item:last .table-all').append(el);
           }
        }
        i++;
      }
    });
    updatenum();
}


//Формат даты для записи в массив объектов (строк таблицы)
function formatDateVal(date) {

  var dd = date.getDate();
  if (dd < 10) dd = '0' + dd;

  var mm = date.getMonth() + 1;
  if (mm < 10) mm = '0' + mm;

  var yy = date.getFullYear();

  return yy + '-' + mm + '-' + dd;
}

//Обновление дней на странице
function updatenum(){//******************************************************************
    n = $('.table-all tr[class!="d-none"]').length
    $('#numdays').html('Выбрано дней: '+ n);
    $('#numdaysIn').val(n);
}

//Рисование календаря по строкам таблицы
function drawCalendar(){//****************************************************************************
    var timestamp, curIndex;
    $('.table-all tr').each(function(index){
        curDateVal = $(this).find('.curDate').val();
        timestamp = new Date (curDateVal);
        timestamp = timestamp.getTime();
        $('#calendar .celldate').each(function( index ) {
            if (timestamp == $(this).attr('cur-date')*1000){
                curIndex = index;
                return true;
            }
        });
        if (!strDays[index]){
            strDays.push({curDateVal:curDateVal, curIndex:curIndex});
        }
        $('#calendar .celldate').eq(curIndex).find('div:first-child').removeClass().addClass('d-block');
    });
}

//Функции запускаемые по отпусканию мыши
$(document).mouseup (function() {
  $('body .dchange').off('mouseenter');
  if (mouse){
      mouse=0;
      updatedates();
  }
});

//Функция удаления дат из таблицы
function delDates(elem){
    elem.click(function(e){
        var index = $(this).parent().parent().index();
        console.log(index);
        console.log(strDays[1]);
        strDays.splice(index, 1);
        console.log(strDays[1]);
        $(this).parent().parent().detach();
        $('body .dchange').each(function() {
            if ($(this).find('div:first-child').hasClass('d-block')){
                $(this).find('div:first-child').removeClass().addClass('d-none')
            }
            if ($(this).hasClass('dop-days')){
                $(this).removeClass(' dop-days');
            }
       });
        updatenum();
        drawCalendar();

    });
}


//Функции, запускаемые, при запуске страницы
$(document).ready(function() {
   updatenum();
   drawCalendar();

   delDates($('.del_dates'));
 });


//Для смены темы
$('#theme').click(function(e){
    if ($('link[href*="calendar2.css"]').prop('disabled')){
        $('link[href*="calendar2.css"]').prop('disabled', false);
        $('link[href*="calendarDark2.css"]').prop('disabled', true);
    }
    else{
        $('link[href*="calendar2.css"]').prop('disabled', true);
        $('link[href*="calendarDark2.css"]').prop('disabled', false);
    }
});
