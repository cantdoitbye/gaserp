function formatRepoRest(repo) {
    if (repo.loading)
        return repo.text;
    //console.log(repo.loading);


    var location = "";
    if (typeof repo.name != 'undefined') {
        var markup = "<div class='select2-result-repository clearfix'>";
        var img = defaultImage;
//        if (repo.image) {
//            img = AWS_BUCKET_URL + "/" + repo.image;
//        }
        markup += "<div class='select2-result-repository__avatar'><img src='" + img + "' height=50 alt='Image' /></div>";

        markup += "<div class='select2-result-repository__meta'>";
        markup += "<div class='select2-result-repository__title'>" + repo.name + "</div>";
        markup += "<div class=''>" + repo.email + "</div>";
    }
    return markup;
}

function formatRepoSelectionRest(repo) {
    return repo.name || repo.text;
}
function filterAjaxCustomer(target, parent) {
    var $ajax2 = $(target);
    $ajax2.select2({
        tags: false,
        width: '100%',
        allowClear: true,
        ajax: {
            url: globalSiteUrl + "/admin/searchListers",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                //console.log(data, params);
                params.page = params.page || 1;
                return {
                    results: data.items.data,
                    pagination: {
                        more: (params.page * 10) < data.items.total
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        placeholder: 'Select lister',
        templateResult: formatRepoRest,
        templateSelection: formatRepoSelectionRest,
        dropdownParent: $('#dropdownParent')
    }).on('change', function (elm) {

    }).on('select2:open', function (elm) {
        $('#dropdownParent').find('.select2-search__field').attr('placeholder', 'Search');
    }).on('select2:unselecting', function () {
        $(this).data('unselecting', true);
    }).on('select2:opening', function (e) {
        if ($(this).data('unselecting')) {
            $(this).removeData('unselecting');
            e.preventDefault();
        }
    });
}
$(document).ready(function () {
    filterAjaxCustomer(".js-example-data-ajax-all", "#dropdownParent")
});
