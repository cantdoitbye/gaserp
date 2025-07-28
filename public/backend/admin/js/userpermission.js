let activeStates = {}; 
function updateDataToBackend(data) {

    $.ajax({
        url: globalSiteUrl + '/admin/update/userPermissions',
        method: 'POST', 
        data: data,
        dataType: 'json',
        success: function(response) {
            if (response.status == 1) {
                $('#idAlertSuccessMsg').show()
                $('#idScriptSuccessMsg').html(response.message)
             
            } else {
                $('#idAlertErrorMsg').show()
                $('#idScriptErrorMsg').html(response.message)
            }
            // window.location.reload();
            console.log(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });


    console.log(data); 
}
function toggle(index) {
    const toggleElement = document.querySelector(`#toggle-${index}`);
    activeStates[index] = !activeStates[index];
    if (activeStates[index]) {
        toggleElement.classList.add('active');
    } else {
        toggleElement.classList.remove('active');
    }

    const userIdValue = $("#userId").val(); // Assuming hiddenId is the ID of your hidden input field

    const data = {
        id: userIdValue,
        permission: index
    };
    if (userIdValue) {
        updateDataToBackend(data);
    }
 
}

$(document).ready(function() {
    $('.btn-red').click(function() {
        const email = $('.form-control').val();

        const activeSections = getActiveSections();

        const data = {
            email: email,
            active_sections: activeSections
        };

        // Send the data to your backend for processing (you need to implement this)
        sendDataToBackend(data);
    });

    $('.btn-blue').click(function() {
        var did = $("#userId").val();
        console.log(did);
        if(did)
        $.get(globalSiteUrl + "/admin/userDashboardAccess?did=" + did, function(r) {
            window.location.reload();
        
        
        
        
        });

    });

    function getActiveSections() {
        const activeSections = [];
        $('.toggle').each(function() {
            if ($(this).hasClass('active')) {
                const sectionName = $(this).attr('id').replace('toggle-', '');
                activeSections.push(sectionName);
            }
        });
        return activeSections;
    }

    

    function sendDataToBackend(data) {
        buttonDisabled('#addBtnUser', 'Add User');

        $.ajax({
            url: globalSiteUrl + '/admin/add/user', // URL to your backend endpoint
            method: 'POST', 
            data: data,
            dataType: 'json',
            success: function(response) {
                buttonEnabled('#addBtnUser', 'Add User');
                if (response.status == 1) {
                    $('#idAlertSuccessMsg').show()
                    $('#idScriptSuccessMsg').html(response.message)
                    $('.toggle.active').removeClass('active');
                    $('.form-control').val('');
                } else {
                    $('#idAlertErrorMsg').show()
                    $('#idScriptErrorMsg').html(response.message)
                }
                // window.location.reload();
                console.log(response); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });


        console.log(data); 
    }
});


