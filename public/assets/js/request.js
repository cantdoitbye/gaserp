function initMap() {
    var input = document.getElementById('searchInput');
    var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['(regions)']
    });
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
        // Location details
        console.log(place.address_components)
        for (var i = 0; i < place.address_components.length; i++) {
            if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                $('#state').val(place.address_components[i].long_name);
            }
            if (place.address_components[i].types[0] == 'locality') {
                $('#city').val(place.address_components[i].long_name);
            }
            if (place.address_components[i].types[0] == 'country') {
                $('#country').val(place.address_components[i].long_name);
            }
        }
        $('#latitude').val(place.geometry.location.lat());
        $('#longitude').val(place.geometry.location.lng());
    });
}

$('.minus').click(function () {
    var is_child = $(this).data('child');
    var $input = $(this).parent().find('input');
    var count = parseInt($input.val()) - 1;
    if (is_child == 1) {
        count = count < 0 ? 0 : count;
        $('#idSelChild').html(count);
    } else {
        count = count < 1 ? 1 : count;
        $('#idSelAdult').html(count);
    }
    $input.val(count);
    $input.change();
    return false;
});
$('.plus').click(function () {
    var is_child = $(this).data('child');
    var $input = $(this).parent().find('input');
    if (is_child == 1) {
        $('#idSelChild').html(parseInt($input.val()) + 1);
    } else {
        $('#idSelAdult').html(parseInt($input.val()) + 1);
    }

    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
});
$('#chooseDate').daterangepicker({
    "singleDatePicker": true,
    minDate: new (Date)
}, function (start, end, label) {
});
$('#checkIn').daterangepicker({
    "singleDatePicker": true,
    minDate: new (Date)
}, function (start, end, label) {
    var sdate = moment(start).add(1, 'days').format('MM/DD/YYYY')
    $('#checkOut').data('daterangepicker').setStartDate(sdate);
});
$('#checkOut').daterangepicker({
    "singleDatePicker": true,
    minDate: moment(new (Date)).add(1, 'days').format('MM/DD/YYYY')
}, function (start, end, label) {
    //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
$('.applyBtn').click(function (event) {
    $('#guestsDropdown').dropdown('toggle')
});
$('.cancelBtn').click(function (event) {
    $('#idChildTotal').val(0)
    $('#idAdultTotal').val(1)
    $('#idSelAdult').html(1);
    $('#idSelChild').html(0);
    $('#guestsDropdown').dropdown('toggle')
});

$(document).ready(function () {
    initMap();
    jQuery.validator.addMethod("greaterThan", function (value, element, params) {
        if ($('#check_in').val() != '') {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val())
                    || (Number(value) > Number($(params).val()));
        } else {
            return true;
        }
    }, 'Must be greater than {0}.');

    $('#searchForm').submit(function () {
        if ($('#searchForm').valid()) {
            $('#is_filter').val(1)
            buttonDisabled($('#idBtnSubmit'));
        }
    });
    $('#searchForm').validate({
        ignore: "",
        rules: {
            check_out: {
                required: {
                    depends: function (element) {
                        return ($('#checkIn').val() != "" && $("#checkOut").val() == '');
                    }
                },
                greaterThan: "#checkIn"
            }
        },
        messages: {
            check_out: {
                required: "End date is Required",
                greaterThan: "Must be greater than start date"
            }
        }
    });

    $('.sc-img-slider').slick({
        lazyLoad: 'ondemand',
        autoplay: false,
        prevArrow: '<button type="button" class="slick-prev"><img src="' + globalSiteUrl + '/assets/img/search/prev.png" alt="Prev"/></button>',
        nextArrow: '<button type="button" class="slick-next"><img src="' + globalSiteUrl + '/assets/img/search/next.png" alt="Prev"/></button>',
    });


    var rangeSlider = document.getElementById('priceSlider');
    if (rangeSlider) {
        noUiSlider.create(rangeSlider, {
            start: [$('#price_start').val(), $('#price_end').val()],
            connect: true,
            tooltips: true,
            format: wNumb({
                decimals: 0,
                prefix: '$'
            }),
            range: {
                'min': parseInt($('#minValue').val()),
                'max': parseInt($('#maxValue').val())
            }
        });
        rangeSlider.noUiSlider.on('change.one', function (values, handle, unencoded, tap, positions, noUiSlider) {
            var start = Math.round(unencoded[0]);
            var end = Math.round(unencoded[1]);
            $('#price_start').val(start);
            $('#price_end').val(end);
            ajaxSearch(1);
        });
    }

});
$(document).on('change', '.checkbox-list input:checkbox', function (event) {
    ajaxSearch(1);
});
$(document).on('change', '.btn-checkbox-radio input:radio', function (event) {
    ajaxSearch(1);
});
// $(document).on('click', '.pagination a', function (event) {
//     event.preventDefault();
//     var page = $(this).attr('href').split('page=')[1];
//     ajaxSearch(page);
// });

function bookingrequest(){
    console.log('ok');
    var adult = $('#adult').val();
    var child = $('#child').val();
    var child = $('#listingid').val();
    console.log(adult);


    if (adult != null || child != null) {
        return false;
    }
    // buttonDisabled($(this));
    $.ajax({
url: globalSiteUrl + "/request-booking/?adult="+adult+"&child="+child+"&listingid="+listingId,
success: function (r)
{
if(r.status==1){
    swalSuccess(r.message);

   }
   else{
    buttonEnabled('#idRequestBooking', 'Request Booking');
                swalError(r.message);
   }
}
});
};
function ajaxSearch(page)
{
    $("#pageLoader").show();
    var data = $('#searchForm').serialize();
    var typeText = $('#typeText').val();
    $.ajax({
        url: globalSiteUrl + "/search/" + typeText + "?page=" + page + "&" + data,
        success: function (data)
        {
            $('.pagination_data').html(data);
            $("#pageLoader").hide();
            scrollToTop('.pagination_data');
            $('.sc-img-slider').slick({
                lazyLoad: 'ondemand',
                autoplay: false,
                prevArrow: '<button type="button" class="slick-prev"><img src="' + globalSiteUrl + '/assets/img/search/prev.png" alt="Prev"/></button>',
                nextArrow: '<button type="button" class="slick-next"><img src="' + globalSiteUrl + '/assets/img/search/next.png" alt="Prev"/></button>',
            });
        }
    });
}
