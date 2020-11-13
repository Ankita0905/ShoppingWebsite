$('#ajax-submit').submit(function (e) {
    e.preventDefault();

    $('#ajax-submit').find(".error").remove();
    var form = $('#ajax-submit');

    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data) {
            if(data.success) {
                if(data.message != '') {
                    alert(data.message);
                    window.location.reload();
                }

                if(data.extra.reload) {
                    window.location.reload();
                }

                if(data.extra.redirect) {
                    window.location.href = data.extra.redirect;
                }
            }
        },
        error: function (data) {
            console.log('An error occurred.');
        }
    });
});