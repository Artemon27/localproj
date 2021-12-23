
$('.select').click(function(){
  if($($(this)[0].nextElementSibling).css('display')=='none'){
    $($(this)[0].nextElementSibling).css('display','block')
  }else{
    $($(this)[0].nextElementSibling).css('display','none')
  }
});

$('.select_body span').click(function(){
  if($($(this)[0].previousElementSibling)[0].checked == false){
    $($(this)[0].previousElementSibling)[0].checked = true;
    let a = $(this)[0].previousElementSibling.attributes.name.value
    if(a == 'staff_id' || a == 'staff'){
      $(this)[0].parentElement.parentElement.parentElement.previousElementSibling.textContent = this.textContent;
    }
  }else{
    $($(this)[0].previousElementSibling)[0].checked = false;
    let a = $(this)[0].previousElementSibling.attributes.name.value
    if(a == 'staff_id' || a == 'staff'){
      $(this)[0].parentElement.parentElement.parentElement.previousElementSibling.textContent = 'Выбрать исполнителя'
    }
  }
});

$('.select_body span input').keyup(function(){
  $($($(this)[0].parentElement)[0].previousElementSibling)[0].checked = true;
});

$('.srch').keyup(function(){
  let val = this.value;
  if(val != ''){
    $($($(this)[0].nextElementSibling)[0].children).each(function(i){
      $(this).css('display','none')
      if(find($(this.lastChild)[0].textContent, val)>=0){
        $(this).css('display','block')
      }
    });
  }else{
    $($($(this)[0].nextElementSibling)[0].children).each(function(i){
      $(this).css('display','block')
    });
  }

});

function find (text, pattern){
  text = text.toLowerCase()
  pattern = pattern.toLowerCase()
  console.log(text)
  t = 0
  last = pattern.length-1
  while (t < pattern.length-last){
    p=0
    while(p<=last && text[t+p] == pattern[p]){
      p++
    }
    if(p==pattern.length){
      return t
    }
    t++
  }
  return -1
}

function Reload(){
  location.reload();
}

$('.button-select').mousedown(function(e){
  let a='';
  if(this.textContent=='+'){
    $(this).empty().append('-').removeClass('btn-success').addClass('btn-danger')
    $(this.parentElement.parentElement).css('background-color','#EEE')
  }else{
    $(this).empty().append('+').removeClass('btn-danger').addClass('btn-success')
    $(this.parentElement.parentElement).css('background-color','white')
  }
  $('.button-select').each(function(i){
    if(this.textContent=='-'){
      a+=$(this.parentElement.parentElement)[0].id.split('room')[1]+'/';
    }
  })
  $('input[name=rooms]')[0].value = a
});

$('.changer').click(function(){
  if(this.attributes.class.value.split('room').length == 2){//комнаты в ключах
    $(this.parentElement.parentElement).find('td').each(function(i){
      if(i>=1 && i<=6){
        this.lastChild.readOnly = false
        $(this.lastChild).css('border','solid 1px black')
      }
      if(i==6){
        this.lastChild.onclick = null
        $(this.lastChild).css('border','solid 1px black')
      }
      if(i>=8 && i<=10){
        $(this).css('display','table-cell')
      }
      if(i>=11 && i<=13 || i==7){
        $(this).css('display','none')
      }
    });
  }else{
    if(this.attributes.class.value.split('user').length == 2){//сотрудники в записи на вечер
    $(this.parentElement.parentElement).find('td').each(function(i){
      if(i>=2 && i<=4){
        this.lastChild.readOnly = false
        $(this.lastChild).css('border','solid 1px black')
      }
      if(i>=5 && i<=6){
        $(this).css('display','table-cell')
      }
      if(i>=7 && i<=8){
        $(this).css('display','none')
      }
    });
  }else{
    $(this.parentElement.parentElement).find('td').each(function(i){ //сотрудники в ключах
      if(i>=1 && i<=5){
        this.lastChild.readOnly = false
        $(this.lastChild).css('border','solid 1px black')
      }
      if(i>=7 && i<=8){
        $(this).css('display','table-cell')
      }
      if(i>=9 && i<=10){
        $(this).css('display','none')
      }
      });
    }
  }
  $('.changer').each(function(i){
    this.disabled = true;
  });
});

$('.new_user').click(function(){
  $('.background_new_user').removeClass('d-none').addClass('d-block');
  $('.new_user_fields').removeClass('d-none').addClass('d-block');
});

$('.background_new_user').click(function(){
  $('.background_new_user').removeClass('d-block').addClass('d-none');
  $('.new_user_fields').removeClass('d-block').addClass('d-none');
});

$('.new_user_fields span').click(function(){
  $('.background_new_user').removeClass('d-block').addClass('d-none');
  $('.new_user_fields').removeClass('d-block').addClass('d-none');
});
