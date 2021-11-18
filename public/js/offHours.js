
var mouse=0;
var strDays = [];

//Кнопка очистки (очищает календарь)
$('#btn-off').click(function(){
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
$('body .dchange').mousedown(function(e) {
    mouse=1;
    if ($(this).hasClass('dchecked')){
        $(this).removeClass('dchecked');
        numdays--;
        updatenum(numdays);
        $('body .dchange').on('mouseenter',function(){
            if (($(this).hasClass('dchecked'))&&(numdays>0)){
                $(this).removeClass('dchecked');
                numdays--;
                updatenum(numdays);
            }
        });
    }
    else{
        $(this).addClass('dchecked');
        $(this).removeClass('dop-days PVT INV OB');
        numdays++;
        updatenum(numdays);
        $('body .dchange').on('mouseenter',function(){
            if (!$(this).hasClass('dchecked')){
                $(this).addClass('dchecked');
                $(this).removeClass('dop-days PVT INV OB');
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
function updatedates(){
    var i = $('#table-all tr .curDate').length;

    $('#table-all tr').each(function( index ) {
      if(index>=i){
        $(this).remove();
      }
    });

    $('#calendar .dchange').each(function( index ) {

      if ($(this).hasClass('dchecked')){
        curDateVal = formatDateVal(new Date ($(this).attr('cur-date')*1000));
        curIndex = index;
        a=0
        $('#table-all tr .curDate').each(function( index ) {
          if(curDateVal == $('#table-all tr .curDate')[index].value)
            a=1
        });
        if(a!=1)
          var el = $('<tr><td><input class="curDate" type="date" name="data['+i+'][date]" value="'+curDateVal+'" readonly></td><td><input type="text" size="5" class="numLine" name="data['+i+'][prpsk]"></td><td><input type="text" size="15" name="data['+i+'][room]"></td><td><input type="text" size="15" name="data['+i+'][phone]"></td><td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td></tr>');

        delDates($('.del_dates', $(el)));
        $('#table-all').append(el);
        updatenum(numdays);
        //console.log($('.del_dates', $(el)));
        i++;
      }
    });
}


//Добавляет change функцию на input в таблице (отслеживание изменений+рисование)
function tableInputOn(){
    $('body input').off('change');
    var numOldLine = 0;
    var numDopLine = 0;
    var numFullLine = 0;
    var curIndex = 0;
    $('#table-all input').change(function( ){
        var i=0;
        var index = $(this).parent().parent().index();

        curIndex = +strDays[index].curIndex;

        numOldLine = +strDays[index].numLine;
        numOldDopLine = +strDays[index].PVT + +strDays[index].INV + +strDays[index].OB;

        strDays[index].numLine = +$(this).parent().parent().find('.numLine').val();
        strDays[index].PVT = +$(this).parent().parent().find('.PVT').val();
        strDays[index].INV = +$(this).parent().parent().find('.INV').val();
        strDays[index].OB = +$(this).parent().parent().find('.OB').val();

        numDopLine = strDays[index].PVT + strDays[index].INV + strDays[index].OB;
        numFullLine = strDays[index].numLine + numDopLine;

        numdays = numdays + strDays[index].numLine - numOldLine
        updatenum(numdays);

        if ((numDopLine > numOldDopLine)||(strDays[index].numLine > numOldLine))
        {
            while(1){
                if (strDays[index+1]){
                    if((curIndex + numFullLine)>=(+strDays[index+1].curIndex)){
                        clearNextDates(index);
                        numFullLine = strDays[index].numLine + strDays[index].PVT + strDays[index].INV + strDays[index].OB;
                    }
                    else{
                        break;
                    }
                }
                else{
                    break;
                }

            }

            numDopLine = strDays[index].PVT + strDays[index].INV + strDays[index].OB;

            if (numOldLine<strDays[index].numLine){
                for (i = numOldLine; i<strDays[index].numLine; i++){
                    $('#calendar .dchange').eq(curIndex +i).addClass('dchecked').removeClass('dop-days INV OB PVT');
                }
            }

            for (i = 0; i<numOldDopLine; i++){
                $('#calendar .dchange').eq(curIndex + strDays[index].numLine + i).removeClass('dop-days INV OB PVT');
            }
            AddPvtInvOb(curIndex, strDays[index].numLine, strDays[index].PVT, strDays[index].INV, strDays[index].OB);
        }
        else {
            if (numOldLine > strDays[index].numLine){
                for (i = strDays[index].numLine; i<numOldLine; i++){
                    $('#calendar .dchange').eq(curIndex+i).removeClass('dchecked');
                }
            }
            for (i = 0; i<numOldDopLine; i++){
                $('#calendar .dchange').eq(curIndex + numOldLine + i).removeClass('dop-days INV OB PVT');
            }
            AddPvtInvOb(curIndex, strDays[index].numLine, strDays[index].PVT, strDays[index].INV, strDays[index].OB);
        }


        $(this).parent().parent().find('.numLine').val(strDays[index].numLine);
        $(this).parent().parent().find('.PVT').val(strDays[index].PVT);
        $(this).parent().parent().find('.INV').val(strDays[index].INV);
        $(this).parent().parent().find('.OB').val(strDays[index].OB);

});
}

function AddPvtInvOb(curIndex, numOldLine, PVT, INV, OB){
    var i=0;
    for (; i<+PVT; i++){
        $('#calendar .dchange').eq(curIndex +numOldLine +i).addClass('dop-days PVT');
    }
    for (; i<+PVT+ +INV; i++){
        $('#calendar .dchange').eq(curIndex +numOldLine +i).addClass('dop-days INV');
    }
    for (; i<+PVT+ +INV+ +OB; i++){
        $('#calendar .dchange').eq(curIndex +numOldLine +i).addClass('dop-days OB');
    }
}

//Очистка дат при переполнении
function clearNextDates(index){
    var indexNext=index+1;
    var i=+0;
    var PVT, INV, OB, numLine, numDopLine;
    var curIndex = +strDays[indexNext].curIndex;
    numLine = +strDays[indexNext].numLine;
    PVT = +strDays[indexNext].PVT;
    INV = +strDays[indexNext].INV;
    OB = +strDays[indexNext].OB;
    strDays[index].numLine = +strDays[index].numLine  + numLine
    strDays[index].PVT = +strDays[index].PVT  + PVT
    strDays[index].INV = +strDays[index].INV  + INV
    strDays[index].OB = +strDays[index].OB  + OB
    numDopLine = PVT+INV+OB;
    for (i=0; i<numLine; i++){
        $('#calendar .dchange').eq(curIndex+i).removeClass('dchecked');
    }
    for (i=0; i<numDopLine; i++){
        $('#calendar .dchange').eq(curIndex+numLine+i).removeClass('dop-days INV OB PVT');
    }
    $('#table-all tr').eq(indexNext).detach();
    strDays.splice(indexNext, 1);
}

//Формат даты для записи в поле "Начало"
function formatDate(date) {

  var dd = date.getDate();
  if (dd < 10) dd = '0' + dd;

  var mm = date.getMonth() + 1;
  if (mm < 10) mm = '0' + mm;

  var yy = date.getFullYear();

  return dd + '.' + mm + '.' + yy;
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
      tableInputOn();
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
   tableInputOn();
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
