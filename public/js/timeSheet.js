
var mouse=0;
var strDays = [];

//Кнопка очистки (очищает календарь)
$('#btn-off').click(function(){
   $('.active input').each(function(index, value){
     value.value=0
   });
});


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
function updatenum(n){
    n = $('#table-all tr').length
    $('#numdays').html('Выбрано дней: '+ n);
    $('#numdaysIn').val(n);
}

//Рисование календаря по строкам таблицы
function drawCalendar(){
    var timestamp, curIndex;
    $('#table-all tr').each(function(index){
        curDateVal = $(this).find('.curDate').val();
        timestamp = new Date (curDateVal);
        timestamp = timestamp.getTime();
        $('#calendar .dchange').each(function( index ) {
            if (timestamp == $(this).attr('cur-date')*1000){
                curIndex = index;
                return true;
            }
        });
        if (!strDays[index]){
            strDays.push({curDateVal:curDateVal, curIndex:curIndex});
        }

        $('#calendar .dchange').eq(curIndex).addClass('dchecked');
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
        $('link[href*="calendarDark3.css"]').prop('disabled', true);
    }
    else{
        $('link[href*="calendar.css"]').prop('disabled', true);
        $('link[href*="calendarDark3.css"]').prop('disabled', false);
    }
});

$('#carouselExampleControls')[0].addEventListener('slid.bs.carousel',function(){
  $('#monthIn')[0].value = $('.active')[0].firstElementChild.attributes['num-mon'].value;
  $('#yearIn')[0].value = $('.active')[0].firstElementChild.attributes['num-year'].value;
  $('.monthIn')[0].value = $('.active')[0].firstElementChild.attributes['num-mon'].value;
  $('.yearIn')[0].value = $('.active')[0].firstElementChild.attributes['num-year'].value;
});

$('input.time').keyup(function(){
  let a = this.value.split(' ')
  this.value = a[0]+' ч.'
})
