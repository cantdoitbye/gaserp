"use strict";


function calendarLoad() {
    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: '',
            right: 'prev,next title'
        },
        defaultView: 'month',
        allDaySlot: false,
        views: {
            month: {
                titleFormat: "MMMM YYYY"
            }
        },
        cache: false,
        editable: false,
        selectable: false,
        selectLongPressDelay: 300,
        eventLongPressDelay: 300,
        eventLimit: true,
        showNonCurrentDates: false,
        loading: function (isLoading, view) {
            if (isLoading) {
                //$('#semiTransparenDiv').show();
            } else {
                //$('#semiTransparenDiv').hide();
            }
        },
        events: function (start, end, timezone, callback) {
            //console.log(start);
            $('#calendar').fullCalendar('removeEvents');
            $('#idTextMonth').html($('#calendar').fullCalendar('getView').intervalStart.format("MMMM"));
            $.ajax({
                method: "POST",
                url: globalSiteUrl + '/lister/get_reservation_calendar',
                data: $('#idFilterForm').serialize() + "&" + $('#formFilter').serialize() + "&start=" + start.format('DD-MM-YYYY') + "&end=" + end.format('DD-MM-YYYY'),
                dataType: 'json',
                success: function (result) {
                    callback(result.events);
                    //$('.fc-view').removeClass('loading');
                }
            });
        },
        eventClick: function (calEvent, jsEvent, view) {

        },
        eventRender: function (event, elt, view) {
//            $('#calendar').fullCalendar('removeEvents');
            var eventDate = event.start;
//            var calendarDate = $('#calendar').fullCalendar('getDate');

            elt.attr('data-booking_id', event.booking_id);
            elt.addClass('viewBookingDetails');
            var $html = '<div class="fc-content " ><table>';
            $html += '<tr class=""><td class="fc-title bg-primary text-white  ' + event.className + ' ' + 'client_column">';
            $html += '<span class="">' + event.title + '</span> &nbsp;';
            $html += '</td></tr></table></div>';
            elt.html($html);
        }
    });
}

$(document).on('click', '#saveNoteBtn', function () {
    var note = $('#idModalNote').val();
    note = $.trim(note);
    $.ajax({
        method: "POST",
        url: globalSiteUrl + '/reservation/note_save',
        data: $('#noteForm').serialize(),
        success: function (result) {
            swalSuccess(result.message)
        }
    });
});
$(document).on('change', '.trip_stage', function () {
    if ($(this).is(':checked')) {
        $('.trip_stage').prop('checked', false);
        $(this).prop('checked', true);
    } else {
        $('.trip_stage').prop('checked', false);
        $(this).prop('checked', false);
    }
});
$(document).on('change', '.trip_status', function () {
    if ($(this).is(':checked')) {
        $('.trip_status').prop('checked', false);
        $(this).prop('checked', true);
    } else {
        $('.trip_status').prop('checked', false);
        $(this).prop('checked', false);
    }
});
$(document).on('change', '.space_type', function () {
    if ($(this).is(':checked')) {
        $('.space_type').prop('checked', false);
        $(this).prop('checked', true);
    } else {
        $('.space_type').prop('checked', false);
        $(this).prop('checked', false);
    }
});
$(document).on('click', '.viewBookingDetails', function () {
    var booking_id = $(this).attr('data-booking_id');
    $.ajax({
        method: "POST",
        url: globalSiteUrl + '/reservation/ajax_details',
        data: "booking_id=" + booking_id,
        success: function (result) {
            $('#idReservationBody').html(result)
            $('#idReservationDetails').modal('show');
            let url = $('#resPrintUrl').val();
            $('.res_print_url').attr('href', url);
        }
    });
});
$(document).ready(function () {
    calendarLoad();
    $('#idFilterClear').click(function () {
        $('#idFilterForm').trigger('reset');
        buttonDisabled('#idFilterClear');
        filterSubmit();
    });
    $('#formFilter').submit(function (e) {
        e.preventDefault();
        var start = $('#calendar').fullCalendar('getView').start.format("YYYY-MM-DD");
        var end = $('#calendar').fullCalendar('getView').end.format("YYYY-MM-DD");
        $.ajax({
            method: "POST",
            url: globalSiteUrl + '/lister/get_reservation_calendar',
            data: $('#idFilterForm').serialize() + "&" + $('#formFilter').serialize() + "&start=" + start + "&end=" + end,
            dataType: 'json',
            success: function (result) {
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', result.events);
            }
        });
    });
    $('#idFilterForm').submit(function (e) {
        e.preventDefault();
        buttonDisabled('#idBtnApply');
        filterSubmit();
    });
});

function filterSubmit() {
    var start = $('#calendar').fullCalendar('getView').start.format("YYYY-MM-DD");
    var end = $('#calendar').fullCalendar('getView').end.format("YYYY-MM-DD");
    $.ajax({
        method: "POST",
        url: globalSiteUrl + '/lister/get_reservation_calendar',
        data: $('#idFilterForm').serialize() + "&" + $('#formFilter').serialize() + "&start=" + start + "&end=" + end,
        dataType: 'json',
        success: function (result) {
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource', result.events);
            $('#filterModal').modal('hide');
            buttonEnabled('#idBtnApply', 'Apply');
            buttonEnabled('#idFilterClear', 'Clear');
        }
    });
}
