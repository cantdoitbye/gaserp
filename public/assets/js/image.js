
function validateMinimumImages(input) {
    var minImages = parseInt(document.getElementById('minImagesInput').value);
    var current = $('.clsEntryPhoto').length;
    console.log("minImages", minImages);

    var links = parseInt(document.getElementById('links').value.trim().split(',').filter(link => link !== "").length);
    console.log("links", links);

    var files = parseInt(current);
    files = files + links;

    console.log("filestol", files);
    console.log("minImages", minImages);

    if (files < minImages) {
        console.log("inlength", minImages);

      idPhotoError.textContent = `Please add at least ${minImages} photos`;
      idPhotoError.style.display = 'block';
      return false;
    } else {
      console.log("files", true);

      idPhotoError.style.display = 'none';
      return true;
    }
  }

function dragNdrop(event) {
    var fileName = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("preview");
    var previewImg = document.createElement("img");
    previewImg.setAttribute("src", fileName);
    preview.innerHTML = "";
    preview.appendChild(previewImg);
}

function drag() {
    document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
}

function drop() {
    document.getElementById('uploadFile').parentNode.className = 'dragBox';
}






$(document).ready(function () {
    idSortable();
    $('#idEntryPhotos').imageuploadify();
    if ($('#listing_type').val() == 2) {
        var exp_type = $('#exp_type').val();
        if (exp_type == 1) {
            $('.clsShow_1').show();
            $('.clsShow_2').hide();
        } else {
            $('.clsShow_1').hide();
            $('.clsShow_2').show();
        }
        if (exp_type == 1) {
            $('#idExpType_2').hide();
            $('#idExpType_1').show();
        } else {
            $('#idExpType_1').hide();
            $('#idExpType_2').show();
        }
    }
  

});

$('.nextStep').click(function () {

   

   

    $('#idPhotoError').hide();

    if ($(this).hasClass('imageButton')) {
        var current = $('.clsEntryPhoto').length;
        var tot = parseInt(current);
        if (tot < 3) {
            $('#idPhotoError').show().html('Please add at least 3 photos');
//            toastError("Please add at least 3 photos");
            return false;
        }
        if (tot > 10) {
            $('#idPhotoError').show().html('Maximum 10 photos are allowed');
//            toastError("Maximum 10 photos are allowed");
            return false;
        }
    }
//    $('#formStep' + current_step).valid();
  
  
});




function compressImage(event, useWebWorker) {
    var files = $('#idEntryPhotos')[0].files;
    dragImageImage(files);
}

async function dragImageImage(files) {
    $('#idPhotoError').hide();
    $('.imageuploadify-container').remove();
    var tour_id = $('#tour_id').val();
    console.log("td", tour_id);
    var formData = new FormData();
    formData.append('tour_id', tour_id);
    var current = $('.clsEntryPhoto').length;
    var sel = files.length;
    var tot = parseInt(current) + parseInt(sel);
    if (tot > 10) {
//        toastError("Maximum 10 photos are allowed");
        $('#idPhotoError').show().html('Maximum 10 photos are allowed');
        return false;
    }
    buttonDisabled('#btnimageuploadify');
    $('.imageButton').attr('disabled', true);
    for (var i = 0, f; f = files[i]; i++) {
        var file = files[i];
        var size = (file.size / 1024 / 1024).toFixed(2);
        var output = await imgCompression(file, 1200);
        formData.append('images[' + i + '][img_thumb]', output)

        output = await imgCompression(file, 4200);
        formData.append('images[' + i + '][img]', output);
    }
    uploadToServer(formData)
}


function imgCompression(file, width) {
    var options = {maxSizeMB: 0.5, maxWidthOrHeight: width, useWebWorker: false}
    return imageCompression(file, options)
}

function uploadToServer(formData) {
    $.ajax({
        url: globalSiteUrl + "/admin/tour/upload_photo",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('.imageuploadify-container').remove();
            $('#idPreviewPhotosBefore').before(data.img_text);
            buttonEnabled('#btnimageuploadify', '');
            $('.imageButton').attr('disabled', false);
            idSortable();
            $('#idEntryPhotos').val("");
        },
        error: function () {
        }
    });
    return false;
}

function idSortable() {
    $("#idPreviewPhotos").sortable({
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            sortingImages(data)
        }
    });
}



$(document).on('click', '.removeEntryImg', function () {
    var id = $(this).data('id');
    $('#idEntryPhoto_' + id).remove();
    if (id != '') {
        $.ajax({
            url: globalSiteUrl + "/tour/remove_photo",
            type: "POST",
            data: "id=" + id,
            success: function (data) {
                buttonEnabled('#btnimageuploadify', '');
            },
            error: function () {
            }
        });
    }
    return false;
});


