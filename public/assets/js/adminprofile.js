var tz = jstz.determine();
var tzname = tz.name();
$("#timezone").val(tzname);

$(function () {
    // $('.image-editor').cropit({
    //     allowDragNDrop: false,
    //     'smallImage': 'allow',
    //     imageState: {
    //         src: profile_url,
    //     },
    // });

    jQuery.validator.addMethod("emailCheck", function (value, element, param) {
        result = this.optional(element) || /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/.test(value);
        return result;
    });
});

$(document).ready(function () {


    $('.chooseInput').click(function () {
        $('.cropit-image-input').click();
    });

    // $('#general-select2').select2({
    //     theme: 'bootstrap-5',
    //     width: "100%",
    //     selectionCssClass: "single--select2",
    //     dropdownCssClass: "single--select2",
    // });
    //
    $('#role-select2').select2({
        theme: 'bootstrap-5',
        width: "100%",
        selectionCssClass: "single--select2",
        // dropdownCssClass: "single--select2",
        dropdownParent: $('#roleSelect')
    });


    $('#industry-select2').select2({
        theme: 'bootstrap-5',
        width: "100%",
        selectionCssClass: "single--select2",
        // dropdownCssClass: "single--select2",
    }).on('change', function (e) {
        $(this).valid();
    });

    $('.type-of-space-select2').select2({
        theme: 'bootstrap-5',
        width: "100%",
        selectionCssClass: "single--select2",
        // dropdownCssClass: "single--select2",
    }).on('change', function (e) {
        $(this).valid();
    });

    $('.city-select2').select2({
        theme: 'bootstrap-5',
        width: "100%",
        selectionCssClass: "single--select2",
        // dropdownCssClass: "single--select2",
    }).on('change', function (e) {
        $(this).valid();
    });

    $('.state-select2').select2({
        theme: 'bootstrap-5',
        width: "100%",
        selectionCssClass: "single--select2",
        // dropdownCssClass: "single--select2",
    }).on('change', function (e) {
        $(this).valid();
    });

    $(".telephone").intlTelInput({
        separateDialCode: true,
        preferredCountries: ['us']
    }).on("countrychange", function (data) {
        var countryData = ($(this).intlTelInput("getSelectedCountryData"))
        $('#country_code').val(countryData.dialCode)
        $('#country_iso_code').val(countryData.iso2)
    });

    var dial_code = $('#country_code').val();
    var iso_code = $('#country_iso_code').val();
    if (dial_code != '' && iso_code != '') {
        $(".telephone").intlTelInput("setCountry", iso_code);
        let countryData = $('.telephone').intlTelInput("getSelectedCountryData");
        $('#country_code').val(countryData.dialCode)
        $('#country_iso_code').val(countryData.iso2)
    } else {
        var country = $(".telephone").intlTelInput("getSelectedCountryData")
        $('#country_code').val(country.dialCode)
        $('#country_iso_code').val(country.iso2)
    }


    $('#addUserForm').validate({
        rules: {
            first_name: {required: true},
            last_name: {required: true},
            email: {
                required: true,
                emailCheck: true,
                remote: {
                    url: globalSiteUrl + '/check-unique-email',
                    type: 'post',
                    data: {
                        email: function () {
                            return $("#sub_user_email").val();
                        }
                    }
                }
            }
        },
        messages: {
            first_name: {required: 'First name is require.'},
            last_name: {required: 'Last name is require.'},
            email: {
                email: "Please enter a valid email address.",
                emailCheck: "Please enter a valid email address.",
                remote: "Email already exist."
            }
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-error').append(error);
        }
    });


    $('#formStep3').validate({
        rules: {
            company_email: {
                emailCheck: true,
                remote: {
                    url: globalSiteUrl + '/check-company-email-exist',
                    type: 'post',
                    data: {
                        email: function () {
                            return $("#companyEmail").val();
                        }
                    }
                }
            }
        },
        messages: {
            company_email: {
                email: "Please enter a valid email address.",
                emailCheck: "Please enter a valid email address.",
                remote: "Email already exist."
            }
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-error').append(error);
        }
    });

    $('#formStep2').validate({
        errorPlacement: function (error, element) {
            $(element).parents('.form-error').append(error);
        }
    });


});

// $('.navStep').click(function () {
//     var current_step = $(this).data('step');
//     $('.steps-sec').removeClass('active');
//     $('.step-' + current_step).addClass('active');
//     $('.navStep').removeClass('active');
//     $('.navStep-' + current_step).addClass('active');
//     var p_width = $('.phone-div').width();
//     $('.iti__country-list').css("width", p_width);
// });

$('.nextStep').click(function () {
    var $this = $(this);
    var current_step = $(this).data('step');
    var next_step = parseInt(current_step) + 1;

    var total_step = $('#total_step').val();
    var total_progress = 100 / parseInt(total_step);
    // var bio = simplemde.value();

    // $("#MyID").val(bio);
   
   

    if (current_step == 3) {
        window.location.href ="/admin/tour-packages";
        // var imageData = $('.image-editor').cropit('export');
        // $('#profile').val(imageData)
    }
    // var renderedHTML = simplemde.options.previewRender(simplemde.value());
    // var result = renderedHTML.replace(/<[^>]*>?/gm, '');
    // if (result.length > 5000) {
    //     $('#MyID-error').css('display', 'block');
    //     $('#MyID-error').text('You can\'t use more than 5000 characters.');
    //     return false;
    // }
    if(current_step == 2){
        var progress = total_progress * next_step;
        $('.step-' + current_step).removeClass('active');
        $('.step-' + next_step).addClass('active');
        $('.progress-bar').css('width', progress + '%')
        $('.navStep').removeClass('active');
        $('.navStep-' + next_step).addClass('active');
        // buttonEnabled($this, 'Save & Next');
    }
    if ($('#formStep' + current_step).valid()) {
        buttonDisabled($this);
        var formData = new FormData($('#formStep' + current_step)[0])
        formData.append('step', current_step);
        console.log(current_step);
        $.ajax({
            url: $('#formStep' + current_step).attr('action'),
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                console.log(response);
                if (response.status == 1) {
                    if (current_step == 3) {
                        if (response.data.is_approved == 1) {
                            window.location.href = globalSiteUrl + '/admin/listers';
                        } else {
                            // $('#successModal').modal({backdrop: 'static', keyboard: false})
                            // $('#successModal').modal('show');
                        }
                        buttonEnabled($this, 'Submit');
                    } else {
                        $('#company_profile_id').val(response.data.id);
                        $('#tour_id').val(response.data.id);

                        var progress = total_progress * next_step;
                        $('.step-' + current_step).removeClass('active');
                        $('.step-' + next_step).addClass('active');
                        $('.progress-bar').css('width', progress + '%')
                        $('.navStep').removeClass('active');
                        $('.navStep-' + next_step).addClass('active');
                        buttonEnabled($this, 'Save & Next');
                          if(current_step == 1){
                            if (response.data.number_of_days) {
                                updateDaysList(response.data.number_of_days);
                            }
                          }
                         
                    }
                    var p_width = $('.phone-div').width();
                    $('.iti__country-list').css("width", p_width);
                } else {
                    buttonEnabled($this, 'Save & Next');
                    toastError(response.message);
                }
            }
        });
    }

});

function updateDaysList(totalDays) {
    var daysListContainer = $('#daysList');
    daysListContainer.empty(); // Clear existing days

    for (var i = 1; i <= totalDays; i++) {
        var dayItem = `
            <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="card user-card">
                        <div class="card-body text-center">
                            <a href="javascript:;" class="selectDay" data-day-number="${i}">
                                 <span class="plus-sign position-relative me-20">
                                <i class="fas fa-plus position-absolute top-50 start-50 translate-middle"></i>
                            </span>
                                Day ${i}
                            </a>
                        </div>
                    </div>
                </div>
        `;
        daysListContainer.append(dayItem);
    }
}

$(document).on('click', '.selectDay', function() {
    var dayNumber = $(this).data('day-number');
    $('#selected_day_number').val(dayNumber); // Set the hidden field
    $('#dayEditor').data('day-number', dayNumber); // Store the day number in the editor
    $('#editorContainer').show();
    // loadDayData(dayNumber);
});

// Show editor for selected day
function showEditorForDay(dayId) {
    editorContainer.style.display = 'block';
    dayEditor.dataset.dayId = dayId;
    // Optionally, load existing data for the day if available
}


$('#saveDayData').on('click', function () {
    var formData = new FormData();
    formData.append('_token', $('input[name="_token"]').val());
    formData.append('tour_id', $('#tour_id').val());
    formData.append('day_number', $('#selected_day_number').val());
    formData.append('day_title', $('#dayTitle').val());
    formData.append('hotel_name', $('#hotel_name').val());
    formData.append('sight_seeing', $('#sight_seeing').val());
    formData.append('included', $('#included').val());
    formData.append('content', $('#dayEditor').val());

    var dayImageFile = $('#day_image')[0].files[0];
    if (dayImageFile) {
        formData.append('day_image', dayImageFile);
    }

    if ($('#dayTitle').val().trim() === '') {
        toastError('Day title cannot be empty');
        return;
    }
    if ($('#dayEditor').val().trim() === '') {
        toastError('Day content cannot be empty');
        return;
    }

    saveDayData(formData);
});
function saveDayData(formData) {
    $.ajax({
        url: savedayDataUrl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status == 1) {
                $('input[name="tour_id"]').val($('#tour_id').val());
                toastSuccess('Data saved successfully');
                $('#editorContainer').hide();
                $('#dayTitle').val('');
                $('#hotel_name').val('');
                $('#sight_seeing').val('');
                $('#included').val('');
                $('#dayEditor').summernote('reset');
                $('#day_image').val('');
                // updateDaysList(response.days);
            } else {
                toastError(response.message);
            }
        },
        error: function(xhr, status, error) {
            toastError('An error occurred while saving the data');
        }
    });
}
$('#companyEmail').change(function () {
    $(this).valid()
});

$('.prevStep').click(function () {
    var current_step = $(this).data('step');
    var next_step = parseInt(current_step) - 1;
    var total_step = $('#total_step').val();
    var total_progress = 100 / parseInt(total_step);
    var progress = total_progress * next_step;
    $('.step-' + current_step).removeClass('active');
    $('.step-' + next_step).addClass('active');
    $('.navStep').removeClass('active');
    $('.navStep-' + next_step).addClass('active');
    $('.progress-bar').css('width', progress + '%')
});

$(document).on('click', '.deleteTeamMember', function () {
    let user_id = $(this).data('id');
    $.ajax({
        method: 'POST',
        url: globalSiteUrl + '/lister/delete-team-member',
        data: "user_id=" + user_id,
        success: function (response) {
            $('.section-' + user_id).remove();
        }
    });
})

$(document).on('click', '.editTeamMember', function () {
    let user_id = $(this).data('id');
    $.get(globalSiteUrl + "/team-member/edit/" + user_id, function (data) {
        $('.subUserNot').show();
        $('label.error').hide();
        $('*').removeClass('error');
        $('#addUserModalLabel').text('Edit team member');
        $('#addUserModal').modal('show');
        $('#user_id').val(data.id);
        $('#firstName').val(data.first_name);
        $('#lastName').val(data.last_name);
        $('#sub_user_email').val(data.email);
        $('#role-select2').val(data.role).trigger('change');
        $('#sub_user_email').attr('disabled', true);
    });
})

$(document).on('click', '#addTeamMember', function (e) {
    $('#addUserForm').trigger("reset");
    $('.subUserNot').hide();
    $('label.error').hide();
    $('*').removeClass('error');
    $('#addUserModalLabel').text('Add team member');
    $('#user_id').val('');
    $('#role-select2').val('').trigger('change');
    $('#sub_user_email').attr('disabled', false);
    $('#addUserModal').modal('show');
});
$(document).on('submit', '#addUserForm', function (e) {
    e.preventDefault();
    let form = $(this);
    if (form.valid()) {
        buttonDisabled($('#addUserBtn'));
        $.ajax({
            url: globalSiteUrl + '/admin/create-lister/add-user',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            success: function (res) {
                console.log(res)
                buttonEnabled($('#addUserBtn'), 'Add User');
                if (res.status == 1) {
                    form.trigger("reset");
                    $('#addUserModal').modal('hide');
                    if (res.data.is_update) {
                        $('.section-' + res.data.user.id).remove();
                    }
                    $('#addUserDiv').prepend(res.data.html);
                } else {

                }
            }
        });
    }
});


function initMap() {

    var input = document.getElementById('searchInput');

    var autocomplete = new google.maps.places.Autocomplete(input);

    var infowindow = new google.maps.InfoWindow();

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
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
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        console.log(place);
        for (var i = 0; i < place.address_components.length; i++) {
            if (place.address_components[i].types[0] == 'postal_code') {
                $('#zip_code').val(place.address_components[i].long_name);
            }
            if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                $('#state').val(place.address_components[i].long_name);
                var state = place.address_components[i].long_name;
            }
            if (place.address_components[i].types[0] == 'locality') {
                $('#city').val(place.address_components[i].long_name);
                var city = place.address_components[i].long_name;
            }
            if (place.address_components[i].types[0] == 'street_number') {
                $('#street_number').val(place.address_components[i].short_name);
            }
            // if (place.address_components[i].types[0] == 'route') {
            //     $('#street_address').val(place.address_components[i].long_name);
            // }
            if (place.address_components[i].types[0] == 'country') {
                $('#country').val(place.address_components[i].long_name);
                var country = place.address_components[i].long_name;
            }
            if (place.address_components[i].types[0] == 'country') {
                // $('#country_code').val(place.address_components[i].short_name);
            }
        }
        $('#latitude').val(place.geometry.location.lat());
        $('#longitude').val(place.geometry.location.lng());
        add_country_state_city(country, state, city);
    });
}

function add_country_state_city(country, state, city) {
    console.log(country, state, city);
    $.get(globalSiteUrl + "/country-state-city/add?country=" + country + "&state=" + state + "&city=" + city, function (res) {
        if (res.status == 1) {
            change_value(res);
        } else {
            console.log(res);
        }
    })
}


function change_value(res) {

    let state = res.data.state
    let city = res.data.city
    let country = res.data.country

    $('#country_id').val(country.id).trigger('change');

    console.log(state.id, state.name)
    console.log(city.id, city.name)
    if (state) {
        var newState = new Option(state.name, state.id, false, false);
        $('.state-select2').append(newState);
        $(".state-select2 option").each(function () {
            $(this).siblings('[value="' + this.value + '"]').remove();
        });
        $('.state-select2').val(state.id).trigger('change');
    } else {
        $('.state-select2').val('').trigger('change');
    }

    if (city) {
        var newCity = new Option(city.name, city.id, false, false);
        $('.city-select2').append(newCity);
        $(".city-select2 option").each(function () {
            $(this).siblings('[value="' + this.value + '"]').remove();
        });
        $('.city-select2').val(city.id).trigger('change');
    } else {
        $('.city-select2').val('').trigger('change');
    }
}


var loadFile = function (event) {
    var fileExtension = event.target.files[0].name.split('.').pop().toLowerCase();
    var reader = new FileReader();
    reader.onload = function () {
        var validImageTypes = ["png", "jpg", "jpeg"];
        if ($.inArray(fileExtension, validImageTypes) < 0) {
            var message = 'Invalid file type. Please select only png, jpg formats';
            toastError(message)
            $('.rangeDiv').addClass('d-none');
        } else {
            $('.rangeDiv').removeClass('d-none');
            // var output = document.getElementById('displayImg');
            // output.src = reader.result;

        }
    };
    reader.readAsDataURL(event.target.files[0]);
};


$(document).ready(function () {
    var p_width = $('.phone-div').width();
    $('.iti__country-list').css("width", p_width);
});
$(window).resize(function () {
    var p_width = $('.phone-div').width();
    $('.iti__country-list').css("width", p_width);
});
$(window).load(function () {
    var p_width = $('.phone-div').width();
    $('.iti__country-list').css("width", p_width);
});


