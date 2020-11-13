var token = $('meta[name="_token"]').attr('content');

$(document).ready(function() {
    zoomSlider();

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
            beforeSend: function() {
                showLoader();
            },
            success: function (data) {
                if(data.success) {
                    $(this).find("button[type='submit']").prop('disabled', true);
                    hideLoader();

                    if(data.message != '') {
                        $('.__modal_message').html(data.message);
                        $('.__modal').modal('show');
                    }

                    if(data.extra.reload) {
                        $('.__modal').on('hidden.bs.modal', function (e) {
                            window.location.reload();
                        });
                    }

                    if(data.extra.redirect) {
                        if(data.message != '') {
                            $('.__modal').on('hidden.bs.modal', function (e) {
                                window.location.href = data.extra.redirect;
                            });
                        }
                        else {
                            window.location.href = data.extra.redirect;
                        }
                    }
                }
                else {
                    if(data.status == 206) {
                        hideLoader();
                        $.each(data.message, function (i, v) {
                            var error = '<div class="error">'+v+'</div>';
                            var split = i.split('.');
                            if(split[2]) {
                                var ind = split[0]+'['+split[1]+']'+'['+split[2]+']';
                                form.find("[name='"+ind+"']").parent().append(error);
                            }
                            else if(split[1]) {
                                var ind = split[0]+'['+split[1]+']';
                                form.find("[name='"+ind+"']").parent().append(error);
                            }
                            else {
                                form.find("[name='"+i+"']").parent().append(error);
                            }
                        });
                    }
                    else if(data.status == 207) {
                        hideLoader();

                        if(data.message != '') {
                            $('.__modal_message').html(data.message);
                            $('.__modal').modal('show');
                        }

                        if(data.extra.reload) {
                            $('.__modal').on('hidden.bs.modal', function (e) {
                                window.location.reload();
                            });
                        }

                        if(data.extra.redirect) {
                            if(data.message != '') {
                                $('.__modal').on('hidden.bs.modal', function (e) {
                                    window.location.href = data.extra.redirect;
                                });
                            }
                            else {
                                window.location.href = data.extra.redirect;
                            }
                        }
                    }
                }
            },
            error: function (data) {
                console.log('An error occurred.');
            }
        });
    });

    $('body').on('click', '.__cart_remove', function(e) {
        e.preventDefault();
        let conf = confirm('Are you sure?');

        if(conf) {
            var product_id = $(this).attr('data-product');
            var route = $(this).attr('data-url');

            let option = {
                _token: token,
                _method: 'post',
                id: product_id
            };

            console.log(option);
            
            showLoader();
            $.ajax({
                type: 'post',
                url: route,
                data: option,
                success: function (data) {
                    alert(data.message);
                    window.location.reload();
                },
                error: function (data) {
                    console.log('An error occurred.');
                    }
            });
        }
    });

    $('body').on('click', '.__show', function(e) {
        e.preventDefault();
        var option = {_token: token, _method: 'get'};
        var route = $(this).attr('data-url');
        $.ajax({
            type: 'post',
            url: route,
            data: option,
            success: function (data) {
                showLoader();
                $('.__show_modal_message').html(data);
                $('.__show_modal').modal('show');
                hideLoader();
            },
            error: function (data) {
                console.log('An error occurred.');
            }
        });
      
    });

    $('body').on('click', '.__cancel_order', function(e) {
        e.preventDefault();
        var option = {_token: token, _method: 'get'};
        var route = $(this).attr('data-url');
        let conf = confirm('Are you sure?');

        if(conf) {
            $.ajax({
                type: 'post',
                url: route,
                data: option,
                success: function (data) {
                    showLoader();
                    $('.__modal_message').html(data.message);
                    $('.__modal').modal('show');
                    $('.__modal').on('hidden.bs.modal', function (e) {
                        window.location.reload();
                    });
                    hideLoader();
                },
                error: function (data) {
                    console.log('An error occurred.');
                }
            });
        }
    });
}); 

function showLoader() {
    $('.loading').show();
}

function hideLoader() {
    $('.loading').hide();
}

function zoomSlider() {
    $(".__parent_img").elevateZoom({
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        easing : true,
        tint:true, 
        tintColour:'#2874F0', 
        tintOpacity:0.5
    });
}
