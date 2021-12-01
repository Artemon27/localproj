$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.toggle-form', function(e) {
            
        var $form = $(this);
        var $btn = $('.btn', $form);

        $.ajax({
            url: $form.attr('route'),
            type: 'post',
            data: { "value" : $('.toggle-value', $form).attr('value'), "field" : $('.toggle-field', $form).attr('value') },
            dataType: 'json',
            beforeSend: function () {
                $btn.prop('disabled', true);
            },
            success: function(data) {
                $btn.prop('disabled', false);

                if(data.status === 'success') {
                    if(parseInt(data.state) === 1) {
                        $('.toggle-value', $form).attr('value',0);
                        $('i', $btn).removeClass('fa-times').addClass('fa-check');
                        $btn.removeClass('btn-danger').addClass('btn-success');
                    } else {
                        $('.toggle-value', $form).attr('value',1);
                        $('i', $btn).removeClass('fa-check').addClass('fa-times');
                        $btn.removeClass('btn-success').addClass('btn-danger');
                    }

                    toastr.success(data.msg);
                    return;
                }

                toastr.error(data.msg);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $btn.prop('disabled', false);
                toastr.error("Error: " + errorThrown);
            }
        });
    });
});