jQuery.validator.addMethod("emailCheck", function (value, element, param) {
    result = this.optional(element) || /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/.test(value);
    return result;
});
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.onlyNumberDot').on('input', function (event) {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('.onlyNumber').on('input', function (event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    window.addEventListener("pageshow", function (event) {
        var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                        window.performance.navigation.type === 2);
        if (historyTraversal) {
            // Handle page restore.
            window.location.reload();
        }
    });

    if (performance.navigation.type == 2) {
        if (currentRoute == 'lister.reservation-create') {
            location.reload(true);
        }
    }

//    window.onpageshow = function (event) {
//        if (event.persisted) {
//            window.location.href = window.location.href;
//        }
//    };

});

function buttonDisabled(target) {
    $(target).attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
}
function buttonEnabled(target, html) {
    $(target).attr('disabled', false).html(html);
}
$(document).on('click', '#idViewDeleteRestore', function () {
    buttonDisabled($(this))
});
$(document).on('click', '.btnRefreshLoader', function (e) {
    if (!e.ctrlKey) {
        buttonDisabled($(this))
    }
});
$(document).on('click', '.iconRefreshLoader', function () {
    $(this).html('<i class="fa fa-spinner fa-spin"></i>');
});
function toastError(message) {
    $.toast({
        heading: 'Error',
        text: message,
        icon: 'error',
        loader: true, // Change it to false to disable loader
        loaderBg: '#9EC600', // To change the background
        position: 'top-center',
        hideAfter: 7000
    });
}
function toastSuccess(message) {
    $.toast({
        heading: 'Success',
        text: message,
        icon: 'success',
        loader: true, // Change it to false to disable loader
        loaderBg: '#9EC600', // To change the background
        position: 'top-center',
    })
}

$(document).on('click', '.closeSuccess', function (e) {
    $('#idAlertSuccessMsg').hide();
});
$(document).on('click', '.closeError', function (e) {
    $('#idAlertErrorMsg').hide();
    $('#idAlertSuccessMsg').hide();
});
function goBackEvent() {
    window.history.back();
}

onlyNumber();
function onlyNumber() {
    $('.onlyNumber').on('input', function (event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}

function scrollToTop(target) {
//    window.scroll(0, 0);
    $('html, body').animate({
        scrollTop: ($(target).offset().top - 100)
    }, 500);

}
function swalSuccess(message) {
    swal({
        title: "Success",
        text: message,
        html: true,
        type: "success",
        showLoaderOnConfirm: true,
        confirmButtonClass: "btn-primary mt-3",
        allowEscapeKey: false,
    }, function (result) {

    });
}
function swalError(message) {
    swal({
        title: "Error",
        text: message,
        html: true,
        type: "error",
        showLoaderOnConfirm: true,
        confirmButtonClass: "btn-primary mt-3",
        allowEscapeKey: false,
    }, function (result) {

    });
}

function CallbackFunction(event) {
    if (window.event) {
        if (window.event.clientX < 40 && window.event.clientY < 0) {
            console.log("back button is clicked");
        } else {
            console.log("refresh button is clicked");
        }
    } else {
        if (event.currentTarget.performance.navigation.type == 2) {
            console.log("back button is clicked");
        }
        if (event.currentTarget.performance.navigation.type == 1) {
            console.log("refresh button is clicked");
        }
    }
}
