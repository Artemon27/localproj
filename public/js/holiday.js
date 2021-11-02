
var mouse=0;
var strDays = [];

//Кнопка очистки (очищает календарь)
$('#btn-off').click(function(){
    $('body .dchange').each(function() {
        if ($(this).hasClass('dchecked')){
            $(this).removeClass('dchecked');
            numdays--;
        }
        if ($(this).hasClass('dop-days')){
            $(this).removeClass('dop-days PVT INV OB');
        }
   });
   updatenum(numdays);
   updatedates();
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
    var curDate = 0;
    var line = 0;
    var numLine = 0;
    var i = 0;
    var $child;
    var curIndex;
    var PVT;
    var INV;
    var OB;
    $('#calendar .dchange').each(function( index ) {
        if (!line){
            if ($(this).hasClass('dchecked')){
                curDate = formatDate(new Date ($(this).attr('cur-date')*1000));
                curDateVal = formatDateVal(new Date ($(this).attr('cur-date')*1000));
                line = 1;
                numLine++;
                curIndex = index;
                PVT = 0;
                INV = 0;
                OB = 0;
            }
            else{
                $(this).removeClass('dop-days INV OB PVT');
            }
        }
        else{
            if ($(this).hasClass('dchecked')){
                numLine++;
            }
            else if ($(this).hasClass('PVT')){
                PVT++;
            }
            else if ($(this).hasClass('INV')){
                INV++;
            }
            else if ($(this).hasClass('OB')){
                OB++;
            }
            else{
                line = 0;
                endDate = new Date ($(this).attr('cur-date')*1000);
                endDate.setDate(endDate.getDate() - 1);                
                $child = $('#table-all').children().eq(i);
                
                if ( $child.html()){
                    $('.curDate', $child).val(curDateVal);
                    $('.numLine', $child).val(numLine);
                    strDays[i].curDateVal=curDateVal;
                    strDays[i].numLine=numLine;
                    strDays[i].curIndex=curIndex;
                    $('.PVT', $child).val(PVT);
                    $('.INV', $child).val(INV);
                    $('.OB', $child).val(OB);
                    strDays[i].PVT=PVT;
                    strDays[i].INV=INV;
                    strDays[i].OB=OB;
                    i++;               
                }
                else{
                    var $el = $('<tr><td><input class="curDate" type="date" name="data['+i+'][datefrom]" value="'+curDateVal+'" readonly></td><td><input type="number" min="0" class="numLine" name="data['+i+'][days]" value="'+numLine+'"></td><td><input type="number" min="0" value="'+PVT+'" name="data['+i+'][PVT]" class="PVT"></td><td><input type="number" min="0" value="'+INV+'" name="data['+i+'][INV]" class="INV"></td><td><input type="number" min="0" value="'+OB+'" name="data['+i+'][OB]" class="OB"></td><td><div class="btn btn-sm btn-outline-danger del_dates">Удалить</div></td></tr>');
                    delDates($('.del_dates', $el));                    
                    $('#table-all').append($el);       
                    i++;
                    strDays.push({curDateVal:curDateVal, numLine:numLine, curIndex:curIndex, PVT:PVT, INV:INV, OB:OB });
                }
                numLine=0;   
            }
        }        
    });
    $child = $('#table-all').children().eq(i);
    while ($child.html()){
        $child.detach();
        $child = $('#table-all').children().eq(i);
        strDays.splice(i, 1);
    }    
}


//Добавляет change функцию на input в таблице (отслеживание изменений+рисование)
function tableInputOn(){
    $('body input').off('change');
    var PVT = 0;
    var INV = 0;
    var OB = 0;
    var numOldLine;
    var numDopLine = 0;
    var numLine=0;
    var numLine2=0;
    var numLine3=0;
    $('#table-all input').change(function( ){
        var i=0;
        var index = $(this).parent().parent().index();
        var curIndex = +strDays[index].curIndex;
        numOldLine = +strDays[index].numLine;
        strDays[index].numLine = $(this).parent().parent().find('.numLine').val();
        PVT = $(this).parent().parent().find('.PVT').val();
        INV = $(this).parent().parent().find('.INV').val();
        OB = $(this).parent().parent().find('.OB').val();
        numOldDopLine = +strDays[index].PVT + +strDays[index].INV + +strDays[index].OB;
        numDopLine = +PVT + +INV + +OB
        if ($(this).hasClass('numLine')){
            if (numOldLine < strDays[index].numLine){
                for (i = numOldLine; i<strDays[index].numLine; i++){
                    if (numDopLine>0){                        
                        if (strDays[+index+1]){
                            if((+curIndex + +numDopLine + +i)>=(strDays[+index+1].curIndex)){
                                strDays[index].numLine = +strDays[index].numLine + +strDays[+index+1].numLine;
                                numLine = PVT + +strDays[+index+1].PVT;
                                numLine2 = INV + +strDays[+index+1].INV;
                                numLine3 = OB + +strDays[+index+1].OB;
                                strDays.splice(index+1, 1);
                                if (numLine!=PVT){
                                    $(this).parent().parent().find('.PVT').val(numLine).change();
                                    PVT = numLine;
                                }
                                if (numLine2!=INV){
                                    $(this).parent().parent().find('.INV').val(numLine2).change();
                                    INV = numLine2;
                                }
                                if (numLine3!=OB){
                                    $(this).parent().parent().find('.OB').val(numLine3).change();
                                    OB = numLine3;
                                }                                                                
                                numDopLine = +PVT + +INV + +OB;
                                $(this).parent().parent().find('.numLine').val(strDays[index].numLine);
                                $(this).parent().parent().parent().children().eq(index+1).detach();
                            }
                        } 
                        $('#calendar .dchange').eq(curIndex +numDopLine +i).removeClass('dchecked').addClass('dop-days');
                        $('#calendar .dchange').eq(curIndex +i).removeClass('dop-days INV OB PVT').addClass('dchecked');
                    }
                    else{
                        if (strDays[+index+1]){
                            if((curIndex +i+1)>=(strDays[+index+1].curIndex)){
                                strDays[index].numLine = +strDays[index].numLine + +strDays[+index+1].numLine;
                                numLine = PVT + +strDays[+index+1].PVT;
                                numLine2 = INV + +strDays[+index+1].INV;
                                numLine3 = OB + +strDays[+index+1].OB;
                                strDays.splice(index+1, 1);
                                if (numLine!=PVT){
                                    $(this).parent().parent().find('.PVT').val(numLine).change();
                                    PVT = numLine;
                                }
                                if (numLine2!=INV){
                                    $(this).parent().parent().find('.INV').val(numLine2).change();
                                    INV = numLine2;
                                }
                                if (numLine3!=OB){
                                    $(this).parent().parent().find('.OB').val(numLine3).change();
                                    OB = numLine3;
                                }
                                numDopLine = +PVT + +INV + +OB;
                                $(this).parent().parent().find('.numLine').val(strDays[index].numLine);
                                $(this).parent().parent().parent().children().eq(index+1).detach();
                            }
                        }                        
                        $('#calendar .dchange').eq(curIndex +i).addClass('dchecked').removeClass('dop-days INV OB PVT');
                    }                    
                } 
                for (i = 0; i<numDopLine; i++){
                    $('#calendar .dchange').eq(curIndex +strDays[index].numLine+i).removeClass('dop-days INV OB PVT');
                }   
                AddPvtInvOb(curIndex, numOldLine, PVT, INV, OB);
            }
            else {
                for (i = numOldLine; i>strDays[index].numLine; i--){
                    if (numDopLine>0){
                        $('#calendar .dchange').eq(curIndex+numDopLine+i-1).removeClass('dchecked dop-days INV OB PVT');
                        $('#calendar .dchange').eq(curIndex+i-1).removeClass('dchecked').addClass('dop-days');
                        for (i = 0; i<numOldDopLine; i++){
                            $('#calendar .dchange').eq(curIndex +numOldLine+i).removeClass('dop-days INV OB PVT');
                        }   
                        AddPvtInvOb(curIndex, numOldLine, PVT, INV, OB);
                    }
                    else{
                        $('#calendar .dchange').eq(curIndex+numDopLine+i-1).removeClass('dchecked');
                    }   
                }   
            }
        }
        else if ($(this).parent().index()>1){ 
            if (numOldDopLine < numDopLine){
                for (i = numOldDopLine; i<numDopLine; i++){
                    if ($(this).hasClass('PVT')){
                        $('#calendar .dchange').eq(curIndex +numOldLine +i).removeClass('dchecked').addClass('dop-days PVT');
                    }
                    if ($(this).hasClass('INV')){
                        $('#calendar .dchange').eq(curIndex +numOldLine +i).removeClass('dchecked').addClass('dop-days INV');
                    }
                    if ($(this).hasClass('OB')){
                        $('#calendar .dchange').eq(curIndex +numOldLine +i).removeClass('dchecked').addClass('dop-days OB');
                    }                    
                    if (strDays[+index+1]){
                        if((curIndex + +numOldLine +i+1)>=(strDays[+index+1].curIndex)){
                            numLine = +strDays[index].numLine + +strDays[+index+1].numLine;
                            strDays.splice(index+1, 1);
                            $(this).parent().parent().find('.numLine').val(numLine).change();
                            $(this).parent().parent().parent().children().eq(index+1).detach();
                            continue;
                        }
                    }                    
                    console.log(1);
                } 
            }  
            else {
                for (i = 0; i<numOldDopLine; i++){
                    $('#calendar .dchange').eq(curIndex +numOldLine+i).removeClass('dop-days INV OB PVT');
                }   
                AddPvtInvOb(curIndex, numOldLine, PVT, INV, OB);
            }
        }
        strDays[index].PVT = PVT;
        strDays[index].INV = INV;
        strDays[index].OB = OB;
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
    $('#numdays').html('Выбрано дней: '+ n);
    $('#numdaysIn').val(n);
}

//Рисование календаря по строкам таблицы
function drawCalendar(){
    var i, numLine, PVT, INV, OB, timestamp, curIndex;
    $('#table-all tr').each(function(index){
        i = +0;
        curDateVal = $(this).find('.curDate').val();
        numLine = +$(this).find('.numLine').val();
        PVT = +$(this).find('.PVT').val();
        INV = +$(this).find('.INV').val();
        OB = +$(this).find('.OB').val();

        timestamp = new Date (curDateVal);
        timestamp = timestamp.getTime();
        $('#calendar .dchange').each(function( index ) {
            if (timestamp == $(this).attr('cur-date')*1000){
                curIndex = index;
                return true;
            }
        });
        if (!strDays[index]){
            strDays.push({curDateVal:curDateVal, numLine:numLine, curIndex:curIndex, PVT:PVT, INV:INV, OB:OB });        
        }        

        for (i = 0; i < numLine; i++){         
            $('#calendar .dchange').eq(curIndex +i).addClass('dchecked');
        }
        for (i = 0; i<PVT; i++){
            $('#calendar .dchange').eq(curIndex +numLine +i).addClass('dop-days PVT');
        } 
        for (; i<PVT+INV; i++){
            $('#calendar .dchange').eq(curIndex +numLine +i).addClass('dop-days INV');
        } 
        for (; i<PVT+INV+OB; i++){
            $('#calendar .dchange').eq(curIndex +numLine +i).addClass('dop-days OB');
        } 
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
        numdays = numdays - strDays[index].numLine;
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
        $('link[href*="calendarDark.css"]').prop('disabled', true);
    }
    else{
        $('link[href*="calendar.css"]').prop('disabled', true);
        $('link[href*="calendarDark.css"]').prop('disabled', false);
    }
});