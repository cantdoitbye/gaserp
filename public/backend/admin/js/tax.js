//for Add Model
$(document).on('click', '#addnewTax', function () {
    $('label.error').hide();
    $('#addTaxForm').trigger("reset");
    $('#addTaxModalHeading').html("Add New Tax");
    $('#addTaxBtn').html("Add");

    $('#addTaxModal').modal('show');
});


$('#addTaxForm').validate({
    // Specify validation rules
    rules: {
        tax_title: {
            required: true, 
        },
        value: {
            required: true, 
            number: true // Ensure that the value is numeric

        },
    },
    messages: {
        tax_title: {
            required: "Please enter tax title.",
            // Add more custom error messages as needed
        },
        tax_title: {
            required: "Please enter tax value.",
            number: "Please enter a valid numeric value."

            // Add more custom error messages as needed
        },
        // Add more form fields with their custom error messages
    }
});




$(document).on('submit', '#addTaxForm', function (e) {
    e.preventDefault();
    let form = $(this);
    if (form.valid()) {
        buttonDisabled('#addTaxBtn');
        var formData = new FormData(form[0])
        $.ajax({
            url: globalSiteUrl + '/admin/tax/add',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                $('.alert').hide();
                $('#addTaxForm').trigger("reset");
                $('#addTaxModal').modal('hide');
                buttonEnabled('#addTaxBtn', 'Add');

                console.log(result);


                if (result.success) {
                    console.log(result);
                    console.log(result.message);

                    window.location.reload();
                    $('#idAlertSuccessMsg').show()
                    $('#idScriptSuccessMsg').html(result.message)
                } else {
                    $('#idAlertErrorMsg').show()
                    $('#idScriptErrorMsg').html(result.message)
                }
            }
        });
    }
});