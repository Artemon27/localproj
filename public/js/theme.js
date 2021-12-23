$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

//Для смены темы
$('#theme').click(function(){
    $(this).attr("disabled", true);
    if (!$('link[theme*="1"]').prop('disabled')){
        $('link[theme*="1"]').prop('disabled', true);
        $('link[theme*="2"]').prop('disabled', false);
        $('#inpDesign').val('2');
    }
    else{
        $('link[theme*="1"]').prop('disabled', false);
        $('link[theme*="2"]').prop('disabled', true);
        $('#inpDesign').val('1');
    }
    if ($(this).attr("disabled")){
        $.ajax({
            url: $(this).attr('route'),
            type: 'post',
            data: { "value" : $('#inpDesign').attr('value'), "field" : 'design' },
            dataType: 'json',
            beforeSend: function () {
            },
            success: function() {
                $('#theme').attr("disabled", false);
            },
            error: function() {
                $('#theme').attr("disabled", false);
            },
        });
    }
});
