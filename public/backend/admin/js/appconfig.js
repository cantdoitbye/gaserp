$(document).on('click', '#addnewTax', function () {
    $('label.error').hide();
    $('#addTaxForm').trigger("reset");
    $('#addTaxModalHeading').html("Add New Tax");
    $('#addTaxBtn').html("Add");

    $('#addTaxModal').modal('show');
});


$('#addTaxForm').validate({
    rules: {
        tax_title: {
            required: true, 
        },
        value: {
            required: true, 
            number: true 

        },
    },
    messages: {
        tax_title: {
            required: "Please enter tax title.",
        },
        tax_title: {
            required: "Please enter tax value.",
            number: "Please enter a valid numeric value."

        },
    }
});



$(document).on('click', '.update-tax-btn', function (e) {
    e.preventDefault();
    let button = $(this);
    let index = button.data('index');
    let taxId = button.data('tax-id');
    let inputValue = $('#taxInput_' + index).val();
    let formData = new FormData();

    formData.append('taxId', taxId);
    formData.append('value', inputValue);

    $.ajax({
        url: globalSiteUrl + '/admin/appconfig/update',
        type: 'post',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            $('.alert').hide();
            $('#addTaxForm').trigger("reset");
            buttonEnabled('#addTaxBtn', 'Add');

            console.log(result);

            if (result.success) {
               

                // window.location.reload();
                $('#idAlertSuccessMsg').show();
                $('#idScriptSuccessMsg').html(result.message);
            } else {
                $('#idAlertErrorMsg').show();
                $('#idScriptErrorMsg').html(result.message);
            }
        }
    });
});
