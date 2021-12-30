var mouse=0;
var strDays = [];
today = new Date ()
mondey = today
today = today.getTime()
for (var i = mondey.getDay(); i >0; i--) {
  mondey -= (24*60*60*1000)
}
mondey = new Date(mondey)
mondey = mondey.getTime()

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
        $(this).find('div:first-child').removeAttr('prpsk');
        $(this).find('div:first-child').removeAttr('room');
        $(this).find('div:first-child').removeAttr('phone');
        updatenum();
        updatedates();
        $('body .dchange').on('mouseenter',function(){
            if ($(this).find('div:first-child').hasClass('d-block')){
                $(this).find('div:first-child').removeClass().addClass('d-none');
                $(this).find('div:first-child').removeAttr('prpsk');
                $(this).find('div:first-child').removeAttr('room');
                $(this).find('div:first-child').removeAttr('phone');
                updatenum();
            }
        });
    }else{
        $(this).find('div:first-child').removeClass().addClass('d-block');
        $(this).find('div:first-child').attr('prpsk', prpsk)
        $(this).find('div:first-child').attr('room', room)
        $(this).find('div:first-child').attr('phone', phone)
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

    $('#calendar .celldate').each(function( index ) {
      if ((new Date ($(this).attr('cur-date')*1000))>=mondey){

        if ($(this).find('div:first-child').hasClass('d-block')){
          if($(this).find('div:first-child').attr('prpsk')){
            prpsk_= $(this).find('div:first-child').attr('prpsk')
            room_= $(this).find('div:first-child').attr('room')
            phone_= $(this).find('div:first-child').attr('phone')
          }else{
            prpsk_=prpsk
            room_=room
            phone_=phone
          }
          timestamp = new Date ($(this).attr('cur-date')*1000+9.5*60*60);
          curDateVal = formatDateVal(timestamp);
          if($('#carouselExampleControls2 .carousel-item:last-child .table-all tr:last-child input.curDate')[0]){
            lastDate= $('#carouselExampleControls2 .carousel-item:last-child .table-all tr:last-child input.curDate')[0].value
            lastDate = new Date(lastDate)
            lastDate_dayofweek=Number(lastDate.getDay());
            lastDate_dayofnum=Number(lastDate.getDate());
            if((lastDate_dayofweek>=timestamp.getDay() || lastDate_dayofweek==0 || timestamp.getDate()-lastDate_dayofnum>=7) && (timestamp.getDay()!=0)){
              var el2 = $('<div class="carousel-item"><table><tr><td class="wd-name p-2" style="width:162px">Дата</td><td class="wd-name p-2" style="width:81px">Пропуск</td><td class="wd-name p-2" style="width:114px">Помещение</td><td class="wd-name p-2" style="width:114px">Телефон</td><td style="width:72px"></td></tr><tbody class="table-all"></tbody></table></div>')
              $('#carouselExampleControls2 .carousel-inner').append(el2);
            }
          }

          if(today<=timestamp.getTime()){
            var el = $('<tr><td><input class="curDate" type="date" name="data['+i+'][date]" value="'+curDateVal+'" readonly></td><td><input type="text" size="5" class="numLine" name="data['+i+'][prpsk]" value="'+prpsk_+'"></td><td><input type="text" size="10" name="data['+i+'][room]" value="'+room_+'"></td><td><input type="text" size="10" name="data['+i+'][phone]" value="'+phone_+'"></td><td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td></tr>');
            delDates($('.del_dates', $(el)));
            $('.carousel-item:last .table-all').append(el);
          }else{
            var el = $('<tr><td><input class="curDate" type="date" name="data['+i+'][date]" value="'+curDateVal+'" readonly></td><td><input type="text" size="5" class="numLine" name="data['+i+'][prpsk]" value="'+prpsk_+'" readonly></td><td><input type="text" size="10" name="data['+i+'][room]" value="'+room_+'" readonly></td><td><input type="text" size="10" name="data['+i+'][phone]" value="'+phone_+'" readonly></td></tr>');
            $('.carousel-item:last .table-all').append(el);
          }
        }
        i++;
      }
    });
    drawLists()
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
        $('#calendar .celldate').eq(curIndex).find('div:first-child').attr('prpsk', $($(this).find('td')[1]).find('input').val())
        $('#calendar .celldate').eq(curIndex).find('div:first-child').attr('room', $($(this).find('td')[2]).find('input').val())
        $('#calendar .celldate').eq(curIndex).find('div:first-child').attr('phone', $($(this).find('td')[3]).find('input').val())
        $('#calendar .celldate').eq(curIndex).find('div:first-child').removeClass().addClass('d-block');
    });
    $('.table-all tr.d-none').each(function(i){
      $(this).remove();
    });
    $($('#carouselExampleControls2 .carousel-item')[0]).addClass('active')
}

function drawLists(){
  $('#carouselExampleControls2 #list').empty();
  $('#carouselExampleControls2 .carousel-control-prev-icon').addClass('d-none')
  $('#carouselExampleControls2 .carousel-control-next-icon').addClass('d-none')
  let a = $('#carouselExampleControls2 .carousel-item').length
  if(a > 1){
    $('.carousel-control-prev-icon').removeClass('d-none')
    $('.carousel-control-next-icon').removeClass('d-none')
    for (var i = 0; i < a; i++) {
      let elem = $("<button type='button' data-bs-target='#carouselExampleControls2' data-bs-slide-to='"+i+"' area-label='Стр."+i+1+"'></button>");
      $('#carouselExampleControls2 #list').append(elem)
    }
    $('#carouselExampleControls2 #list button:first-child').addClass('select')
  }
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
        drawLists()
    });
}


//Функции, запускаемые, при запуске страницы
$(document).ready(function() {
   updatenum();
   drawCalendar();
   updatedates();
   delDates($('.del_dates'));
   $('#carouselExampleControls2')[0].addEventListener('slid.bs.carousel',function(){
     $('#carouselExampleControls2 #list button').each(function() {
       $(this).removeClass('select');
     });
     $('#carouselExampleControls2 .carousel-item').each(function(i) {
       if($(this).hasClass('active')){
         $($('#carouselExampleControls2 #list button')[i]).addClass('select');
       }
    });
   });
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
