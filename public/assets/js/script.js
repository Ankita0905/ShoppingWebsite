
var pageContainer = $('#pagination');
var url = pageContainer.data('url');
var sortEntity = '';
var sortOrder = '';
var perPage = $('#perPage').val();
var token = $('meta[name="_token"]').attr('content');
var keyword = '';
var ajaxReq = null;
var formData = '';

$(document).ready(function () {
   if(url != undefined) {
       pagination();
   }
});

$(".select2").select2();

$('.__from_date').datepicker({
    dateFormat: 'dd-mm-yy',
    changeYear: true,
    changeMonth: true,
    onSelect: function(dateText) {
        $('.__to_date').val('');
        $(".__to_date").datepicker('option', 'minDate', dateText);
    }
});

initSample();

$('.__to_date').datepicker({
    dateFormat: 'dd-mm-yy',
    changeYear: true,
    changeMonth: true,
    minDate: $('.__from_date').val()
});

$('.datepicker_future').datepicker({
    dateFormat: 'dd-mm-yy',
    changeYear: true,
    changeMonth: true,
    minDate: 0
});

$('.datepicker').datepicker({
    dateFormat: 'dd-mm-yy',
    changeYear: true,
    changeMonth: true
});

$('body').on('change', '.__check_all', function() {
    if ($(this).is(':checked')) {
        $('.__check').prop('checked', true);
        $('.__check').parent().parent().addClass('bg-warning text-white');
    } else {
        $('.__check').prop('checked', false);
        $('.__check').parent().parent().removeClass('bg-warning text-white');
    }
});

$('body').on('change', '.__check', function() {
    if ($(this).is(':checked')) {
        $(this).parent().parent().addClass('bg-warning text-white');
    } else {
        $(this).parent().parent().removeClass('bg-warning text-white');
    }
});

$('body').on('change', '.__status', function(e) {
    e.preventDefault();
    var option = {_token: token, _method: 'post'};
    var route = $(this).attr('data-route');

    $.ajax({
        type: 'post',
        url: route,
        data: option,
        success: function (data) {
            /*if (data.success && data.status == 201) {
             alert(data.message);
             // window.location.reload();
             }*/
        },
        error: function (data) {
            alert('An error occurred.');
            // console.log('An error occurred.');
        }
    });
});

$(document).ready(function() {
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        url = $(this).attr('href');
        pagination();
        window.history.pushState('', '', url);
    });

    $('body').on('click', '#pagination th a', function(e) {
        e.preventDefault();
        sortEntity = $(this).attr('data-sortEntity');
        sortOrder = $(this).attr('data-sortOrder');
        pagination();
        window.history.pushState('', '', url);
    });

    $('body').on('change', '#perPage', function() {
        perPage = $(this).val();
        url = pageContainer.data('url');
        pagination();
        window.history.pushState('', '', url);
    });

    $('body').on('keyup', 'input[name=keyword]', function() {
        if (ajaxReq != null) ajaxReq.abort();
        keyword = $(this).val();
        pagination();
    });

    $('body').on('keyup', 'input[name=keyword]', function() {
        if (ajaxReq != null) ajaxReq.abort();
        keyword = $(this).val();
        pagination();
    });

    $('#form-search').submit(function(e) {
        e.preventDefault();
        $('#form-search').find(".error").remove();
        formData = $(this).serialize();
        url = pageContainer.data('url');
        window.history.pushState('', '', url);
        pagination();
    });

    $('#ajax-submit').submit(function (e) {
        e.preventDefault();

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

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

    $('body').on('click', '.__drop', function(e) {
        e.preventDefault();
        var conf = confirm('Are you sure ?');
        if(conf) {
            var option = {_token: token, _method: 'delete'};
            var route = $(this).attr('data-url');
            showLoader();
            $.ajax({
                type: 'post',
                url: route,
                data: option,
                success: function (data) {
                    if(data.success && data.status == 201) {
                        showLoader();
                        alert(data.message);
                        window.location.reload();
                    }
                },
                error: function (data) {
                    console.log('An error occurred.');
                }
            });
        }
    });

    $('body').on('click', '.__toggle', function(e) {
        e.preventDefault();
        var conf = confirm('Are you sure to change status?');
        if(conf) {
            var option = {_token: token, _method: 'post'};
            var route = $(this).attr('data-route');
            showLoader();

            $.ajax({
                type: 'post',
                url: route,
                data: option,
                success: function (data) {
                    if (data.success && data.status == 201) {
                        showLoader();
                        alert(data.message);
                        window.location.reload();
                    }
                },
                error: function (data) {
                    console.log('An error occurred.');
                }
            });
        }
    });

    $('body').on('click', '.__dynamic', function(e) {
        e.preventDefault();

        var route = $(this).attr('href');
        var heading = $(this).attr('data-heading');
        showLoader();
        $.ajax({
            type: 'get',
            url: route,
            success: function (response) {
                $('.__dynamic_heading').html(heading);
                $('.__dynamic_detail').html(response);
                hideLoader();
                $('.__dynamic_modal').modal('show');
            },
            error: function (response) {
                console.log('An error occurred.');
            }
        });
    });

    $('body').on('click', '.__toggle_all', function() {
        if ($('.__check:checked').length <= 0) {
            alert('Please select alteast one status');
            return false;
        }

        var ids = [];
        $(".__check:checked").each(function() {
            ids.push($(this).val());
        });

        var option = {
            _token: token,
            _method: 'post',
            ids: ids
        };
        var route = $(this).attr('data-route');
        showLoader();

        $.ajax({
            type: 'post',
            url: route,
            data: option,
            success: function (data) {
                if (data.success && data.status == 201) {
                    showLoader();
                    alert(data.message);
                    window.location.reload();
                }
            },
            error: function (data) {
                console.log('An error occurred.');
            }
        });
    });

    $/*('body').on('click', '.__add_row', function(e) {
        e.preventDefault();
        var source = $(this).data('source');
        var target = $(this).data('target');
        // var count = $(target).find('tr').length;
        // var count = 1;
        var count = $(this).data('count');
        count++;
        $(this).attr('data-count', count);
        console.log($(this).attr('data-count'));

        // console.log($(target).find('tr').last().find('td').length, count);

        var html = $(source).find('tbody').html();
        $(target).append(html).show();
    });

    $('body').on('click', '.__remove_row', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });*/
});

function ajaxFire(target, route) {
    $(target).html('');
    $(target).select2();

    $.ajax({
        type: 'GET',
        url: route,
        beforeSend: function() {
            showLoader();
        },
        success: function (data) {
            if(data.success) {
                hideLoader();

                $(target).html(data.options);
                $(target).select2();
            }
        },
        error: function (data) {
            console.log('An error occurred.');
        }
    });
}

function pagination() {
    if(formData != '') {
        formData = formData + '&';
    }

    var option =  formData + 'sortEntity=' + sortEntity +
        '&sortOrder=' + sortOrder +
        '&perPage=' + perPage +
        '&keyword=' + keyword +
        '&_token=' + token;

    ajaxReq = $.ajax({
        type: 'GET',
        url: url,
        data: option,
        beforeSend: function() {
            showLoader();
        },
        success: function (data) {
            ajaxReq = null;
            if((data.success == false) && (data.status == 206)) {
                $.each(data.message, function (i, v) {
                    var error = '<div class="error">'+v+'</div>';
                    $('#form-search').find("[name='"+i+"']").parent().append(error);
                });
            }
            else {
                pageContainer.html(data);
            }
            hideLoader();
        },
        error: function (data) {
            console.log('An error occurred.');
        }
    });
}

function showLoader() {
    $('.loading').show();
}

function hideLoader() {
    $('.loading').hide();
}

function toggleDetail(reference) {
    $('body').find(reference).toggleClass('hidden');
} 