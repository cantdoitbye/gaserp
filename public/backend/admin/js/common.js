$(document).ready(function () {
    // fetch_data(1);

    $('#filterBtn').click(function () {
        $('body').toggleClass("filter-body-open");
        $('.filter-bar').toggleClass("show-filter");
    });
    $('.filter-close').click(function () {
        $('body').toggleClass("filter-body-open");
        $('.filter-bar').toggleClass("show-filter");
    });


    
});

