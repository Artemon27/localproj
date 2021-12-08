var mouse=0;
var strDays = [];
today = new Date ()
today = today.getTime()
endday = today+7*24*60*60*1000

//Кнопка очистки (очищает календарь)
$('#btn-off').click(function(){//**********************************************************
    $('body .dchange').each(function() {
        if ($(this).hasClass('dchecked')){
            $(this).removeClass('dchecked');
            numdays--;
        }
   });
   updatenum(numdays);
   $('#table-all').empty();
});

//Клик по календарю (выделяет или снимает выделение)
$('body .dchange').mousedown(function(e) {//*************************************************
    mouse=1;
    timestamp = e.currentTarget.attributes[3].value*1000
    if ($(this).hasClass('dchecked') || $(this).find('div:first-child').css('display') == 'block'){
        if($(this).hasClass('dchecked')){
          $(this).removeClass('dchecked');
        }else{
          $(this).find('div:first-child').css('display','none');
        }
        numdays--;
        updatenum(numdays);
        updatedates();
        $('body .dchange').on('mouseenter',function(){
            if (($(this).hasClass('dchecked') || $(this).find('div:first-child').css('display') == 'block')&&(numdays>0)){
                if($(this).hasClass('dchecked')){
                  $(this).removeClass('dchecked');
                }else{
                  $(this).find('div:first-child').css('display','none');
                }
                numdays--;
                updatenum(numdays);
            }
        });
    }else{
      console.log(today<=timestamp && endday>=timestamp);
        if(today<=timestamp && endday>=timestamp){
          $(this).addClass('dchecked');
        }else{
          $(this).find('div:first-child').css('display','block');
        }
        numdays++;
        updatenum(numdays);
        updatedates();
        $('body .dchange').on('mouseenter',function(){
            if (!$(this).hasClass('dchecked') || $(this).find('div:first-child').css('display') != 'block'){
              if(today<=timestamp && endday>=timestamp){
                $(this).find('div:first-child').css('display','block');
              }else {
                $(this).addClass('dchecked');
              }
                numdays++;
                updatenum(numdays);
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

    $('#table-all tr').each(function( index ) {
      if(index>=i){
        $(this).remove();
      }
    });

    $('#calendar .dchange').each(function( index ) {

      if ($(this).hasClass('dchecked') || $(this).find('div:first-child').css('display') == 'block'){
        timestamp = new Date ($(this).attr('cur-date')*1000);
        curDateVal = formatDateVal(timestamp);
        curIndex = index;
        a=0
        $('#table-all tr .curDate').each(function( index ) {
          if(curDateVal == $('#table-all tr .curDate')[index].value)
            a=1
        });
        if(a!=1)
          console.log(today+' '+timestamp+' '+endday);
          if(today<=timestamp && endday>=timestamp){
            var el = $('<tr class="visible"><td><input class="curDate" type="date" name="data['+i+'][date]" value="'+curDateVal+'" readonly></td><td><input type="text" size="5" class="numLine" name="data['+i+'][prpsk]" value="'+prpsk+'"></td><td><input type="text" size="10" name="data['+i+'][room]" value="'+room+'"></td><td><input type="text" size="10" name="data['+i+'][phone]" value="'+phone+'"></td><td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td></tr>');
          }else{
            var el = $('<tr class="invisible"><td><input class="curDate" type="date" name="data['+i+'][date]" value="'+curDateVal+'" readonly></td><td><input type="text" size="5" class="numLine" name="data['+i+'][prpsk]" value="'+prpsk+'"></td><td><input type="text" size="10" name="data['+i+'][room]" value="'+room+'"></td><td><input type="text" size="10" name="data['+i+'][phone]" value="'+phone+'"></td><td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td></tr>');
          }
        delDates($('.del_dates', $(el)));
        $('#table-all').append(el);
        updatenum(numdays);
        i++;
      }
    });
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
function updatenum(n){//******************************************************************
    n = $('#table-all tr').length
    $('#numdays').html('Выбрано дней: '+ n);
    $('#numdaysIn').val(n);
}

//Рисование календаря по строкам таблицы
function drawCalendar(){//****************************************************************************
    var timestamp, curIndex;
    $('#table-all tr').each(function(index){
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
        if(today<=timestamp && endday>=timestamp){
          $('#calendar .celldate').eq(curIndex).addClass('dchecked');
        }else{
          $('#calendar .celldate').eq(curIndex).find('div:first-child').css('display','block');
        }
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
        //numdays = numdays - strDays[index].numLine;
        console.log(strDays[1]);
        strDays.splice(index, 1);
        console.log(strDays[1]);
        $(this).parent().parent().detach();
        $('body .dchange').each(function() {
            if ($(this).hasClass('dchecked')){
                $(this).removeClass('dchecked');
            }
            if ($(this).hasClass('dop-days')){
                $(this).removeClass(' dop-days');
            }
       });
        updatenum(numdays);
        drawCalendar();

    });
}


//Функции, запускаемые, при запуске страницы
$(document).ready(function() {
   updatenum(numdays);
   drawCalendar();

   delDates($('.del_dates'));
 });


//Для смены темы
$('#theme').click(function(e){
    if ($('link[href*="calendar.css"]').prop('disabled')){
        $('link[href*="calendar.css"]').prop('disabled', false);
        $('link[href*="calendarDark2.css"]').prop('disabled', true);
    }
    else{
        $('link[href*="calendar.css"]').prop('disabled', true);
        $('link[href*="calendarDark2.css"]').prop('disabled', false);
    }
});
