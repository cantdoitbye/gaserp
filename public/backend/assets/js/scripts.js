/*!
 * Start Bootstrap - SB Admin v6.0.2 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2020 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */


window.onpageshow = function (event) {
    if (event.persisted) {
        window.location.href = window.location.href;
    }
};


(function ($) {
    "use strict";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
        $(".nav-icon-btn").toggleClass("open");
    });

    $(".btn-loader").on('click', function () {
        var $this = $(this);
        var loadingText = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        // disable button


        if ($(this).html() !== loadingText) {
            $(this).prop("disabled", true);
            $this.data('original-text', $(this).html());
            $this.html(loadingText);
        }
        setTimeout(function () {
            $this.html($this.data('original-text')).prop('disabled', false);
        }, 3000);
    });
})(jQuery);

jQuery.validator.addMethod("urlCheck", function (value, element, param) {
    if (value) {
        return /^http(s)?:\/\/(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(value);
    } else {
        return true;
    }
    // return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(value);
});
jQuery.validator.addMethod("emailCheck", function (value, element, param) {
    var result;
    result = this.optional(element) || /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/.test(value);
    return result;
});

jQuery.validator.addMethod("noSpace", function (value, element) {
    if ($.trim(value) == '') {
        //$(element).val("");
        return false;
    } else {
        return true;
    }
}, "Space are not allowed");


$(document).ready(function () {

});

$(document).on('click', '.closeWarning', function () {
    $(this).parent('div').hide();
})

function buttonDisabled(target) {
    $(target).attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
}

function buttonEnabled(target, html) {
    $(target).attr('disabled', false).html(html);
}
var globalDate = {
    'Lifetime': [moment('2022-10-01'), moment()],
    'Today': [moment(), moment()],
    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    'This Month': [moment().startOf('month'), moment().endOf('month')],
    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    'This Year': [moment().startOf('year'), moment().endOf('year')],
    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
};

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
function goBackEvent() {
    window.history.back();
}

$('.onlyNumberDot').on('input', function (event) {
    this.value = this.value.replace(/[^0-9.]/g, '');
});
$('.onlyNumber').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
$(document).on('click', '.btnRefreshLoader', function (e) {
    if (!e.ctrlKey) {
        buttonDisabled($(this))
    }
});
$(document).on('click', '.iconRefreshLoader', function () {
    $(this).html('<i class="fa fa-spinner fa-spin"></i>');
});




function createThumbnail(imageSrc) {
    var img = new Image();
    img.src = imageSrc;

    img.onload = function() {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');

        // Set the thumbnail dimensions
        var thumbnailWidth = 250; 
        var thumbnailHeight = (img.height / img.width) * thumbnailWidth;

        canvas.width = thumbnailWidth;
        canvas.height = thumbnailHeight;

        ctx.drawImage(img, 0, 0, thumbnailWidth, thumbnailHeight);

        // Convert the canvas to a data URL
        var thumbnailDataUrl = canvas.toDataURL();
        
        // Set the value of the hidden input to the thumbnail data URL
        $('#image_thumb').val(thumbnailDataUrl);
        
        // Display the thumbnail in the preview
        $('#preview').attr('src', thumbnailDataUrl);
    }
}