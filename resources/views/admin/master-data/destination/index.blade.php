@extends('admin.layout.admin-app')
@php
    // Fetch the authenticated admin's permissions
    $permissions = json_decode(Auth::guard('admin')->user()->permissions, true);
@endphp
@section('content')
    <div class="container-fluid">
        <div class="py-4">
            <div class="d-sm-flex justify-content-between mb-3 mc-flex">
                <h2 class="page-title">{{ isDeleted() }}  Destination (<span id="total_record"></span>)</h2>
                @if (isset($permissions['destinations']) && in_array('add', $permissions['destinations']))
                <button class="btn btn-primary mw-100" id="create_new_destination_offer">Add
                </button>
                @endif
            </div>
            <div class="card admin-card mb-4">
                @include('errors.javascript_message_error_success')
                @include('errors.message_error_success')
                <div class="card-body">
                    <div class="table-responsive admin-responsive lr_table">
                        <table class="table table-bordered tablesaw tablesaw-stack" data-tablesaw-mode="stack"
                               id="userTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>

                                <th>N0.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php $deleted_text = "View deleted destination"; ?>
            @include('admin.datatable.restore_button')
        </div>
    </div>
    @include('admin.master-data.destination.add')
    <input type="hidden" name="deleted" id="deleted" value="{{$deleted}}">
@endsection
@section('pagescript')

<script>
$(document).ready(function () {
    var table = $('#userTable');

    // DataTable initialization
    table.DataTable({
        "scrollX": true,
        processing: true,
        serverSide: true,
        "order": [[0, "desc"]],
        "bAutoWidth": false,
        ajax: {
            url: globalSiteUrl + "/admin/master/destinations",
            data: function (data) {
                data.deleted = $('#deleted').val();
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', sortable: false},
        ],
        "drawCallback": function (settings) {
            $('#total_record').html(settings.json.recordsTotal)
            $('#deletedRecord').html(settings.json.deletedRecord)
            $('.accommodation_offer_count').html(settings.json.recordsTotal)
        }
    });

    // Form validation
    $('#destination_from').validate({
        rules: {
            name: {
                required: true,
                noSpace: true,
            },
            image: {
                required: true,
                accept: "image/*",
                filesize: 2097152, // 2MB
            }
        },
        messages: {
            name: {
                required: "Name field is required.",
            },
            image: {
                required: "Please select an image.",
                accept: "Please select a valid image file.",
                filesize: "File size must be less than 2MB."
            }
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-error').append(error);
        }
    });

    // Custom validation method for file size
    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, 'File size must be less than {0}');

    // Image preview
    $('#image').change(function(){
        readURL(this);
    });

    // Form submission
    $('#destination_from').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        
        if (form.valid()) {
            buttonDisabled('#saveBtn');
            
            var formData = new FormData(this);
            console.log(formData);
            
            $.ajax({
                url: globalSiteUrl + "/admin/master/destination/add",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (result) {
                    $('.alert').hide();
                    form[0].reset();
                    $('#editModal').modal('hide');
                    table.DataTable().ajax.reload();
                    buttonEnabled('#saveBtn', 'Save');
                    if (result.status == 1) {
                        $('#idAlertSuccessMsg').show();
                        $('#idScriptSuccessMsg').html(result.message);
                    } else {
                        $('#idAlertErrorMsg').show();
                        $('#idScriptErrorMsg').html(result.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    $('#idAlertErrorMsg').show();
                    $('#idScriptErrorMsg').html("An error occurred while processing your request.");
                    buttonEnabled('#saveBtn', 'Save');
                }
            });

            // Debug: Log FormData contents
            console.log('Form Data:');
            for (var pair of formData.entries()) {
                console.log(pair[0] + ', ' + (pair[1] instanceof File ? pair[1].name : pair[1]));
            }
        }
    });

    // Add new destination
    $(document).on('click', '#create_new_destination_offer', function () {
        $('label.error').hide();
        $('#destination_id').val('');
        $('#destination_from').trigger("reset");
        $('#modelHeaderTitle').html("Add destination");
        $('#editModal').modal('show');
    });

    // Edit destination
    $(document).on('click', '.editRow', function () {
        let id = $(this).data('id');
        $.get(globalSiteUrl + "/admin/master/destination/edit/" + id, function (data) {
            $('label.error').hide();
            $('*').removeClass('error');
            $('#modelHeaderTitle').text('Edit destination type');
            $('#editModal').modal('show');
            $('#destination_id').val(data.id);
            $('#name').val(data.name);
            // If there's an existing image, you might want to show it here
        });
    });

    
    // Other existing event handlers (changeStatus, deleteRow, etc.)...
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            $('#preview').attr('src', e.target.result);
            $('#image-preview').show();
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

    </script>
    @endsection
@section('pagescripts')
    <script>
        var table = $('#userTable');
        $(document).ready(function () {

            table.DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                "order": [[0, "desc"]],
                "bAutoWidth": false, // Disable the auto width calculation
                ajax: {
                    url: globalSiteUrl + "/admin/master/destinations",
                    data: function (data) {
                        data.deleted = $('#deleted').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', sortable: false},
                ],
                "drawCallback": function (settings) {
                    $('#total_record').html(settings.json.recordsTotal)
                    $('#deletedRecord').html(settings.json.deletedRecord)
                    $('.accommodation_offer_count').html(settings.json.recordsTotal)
                }
            });

            $('#destination_from').validate({
                rules: {
                    name: {
                        required: {
                            depends: function () {
                                $(this).val($(this).val().replace(/\s+/g, " "));
                                return true;
                            }
                        },
                        noSpace: true,
                    },
                //     image: {
                //     required: true,
                //     // accept: "image/jpeg,image/png,image/gif",
                //     filesize: 2097152,
                // }
                },
                messages: {
                    name: {
                        required: "Name field is required.",
                    },
                //     image: {
                //     required: "Please select an image.",
                //     accept: "Please select a valid image file.",
                //     filesize: "File size must be less than 2MB."
                // }
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-error').append(error);
                }
            });
        





      
     
       



        // Custom validation method for file size
    
        //for Add Model
        $(document).on('click', '#create_new_destination_offer', function () {
            $('label.error').hide();
            $('#destination_id').val('');
            $('#destination_from').trigger("reset");
            $('#modelHeaderTitle').html("Add destination");
            $('#editModal').modal('show');
        });

        //for Edit Model
        $(document).on('click', '.editRow', function () {
            let id = $(this).data('id');
            $.get(globalSiteUrl + "/admin/master/destination/edit/" + id, function (data) {
                $('label.error').hide();
                $('*').removeClass('error');
                $('#modelHeaderTitle').text('Edit destination type');
                $('#editModal').modal('show');
                $('#destination_id').val(data.id);
                $('#name').val(data.name);
            });
        });

        $(document).on('submit', '#destination_from', function (e) {
            e.preventDefault();
            let form = $(this);
            if (form.valid()) {
                buttonDisabled('#saveBtn');
        

                $.ajax({
                    url: globalSiteUrl + "/admin/master/destination/add",
                    type: "POST",
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (result) {
                        $('.alert').hide();
                        $('#destination_from').trigger("reset");
                        $('#editModal').modal('hide');
                        table.DataTable().ajax.reload();
                        buttonEnabled('#saveBtn', 'Save');
                        if (result.status == 1) {
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

      

      

        //Delete Function for DataTable
        $(document).on('click', '.deleteRow', function () {
            let id = $(this).data('id');
            let url = $(this).data('url');
            let name = $(this).data('name');
            let type = $(this).data('type');

            $('#deleteRowId').val(id)
            $('#deleteUrl').val(url)
            $('#deleteType').val(type)

            $('#deleteModalHeading').html('Delete destination');
            $('#deleteBtn').html('Delete')
            $('#deleteContent').html('Are you sure you want to delete <span id="deleteNameLabel" class="text-primary">' + name + '</span> destination?')
            if (type == 2) {

                $('#deleteModalHeading').html('Restore destination');
                $('#deleteBtn').html('Restore')
                $('#deleteContent').html('Are you sure you want to restore <span id="deleteNameLabel" class="text-primary">' + name + '</span> destination?')
            }
            if (type == 3) {
                $('#deleteModalHeading').html('Permanent Delete Machine');
                $('#deleteContent').html('Are you sure you want to permanent delete <span id="deleteNameLabel" class="text-primary">' + name + '</span> destination?')
            }

            $('#deleteModal').modal('show');
        });

        $(document).on('click', '#deleteBtn', function () {
            let id = $('#deleteRowId').val();
            let url = $('#deleteUrl').val();
            let type = $('#deleteType').val();
            $('#deleteModal').modal('hide');
            $.ajax({
                method: 'POST',
                url: url,
                data: "id=" + id + "&type=" + type,
                success: function (response) {
                    if (response.status == 1) {
                        $('#idAlertErrorMsg').hide()
                        $('#idAlertSuccessMsg').show()
                        $('#idScriptSuccessMsg').html(response.message)
                        table.DataTable().ajax.reload();
                    } else {
                        $('#idAlertSuccessMsg').hide()
                        $('#idAlertErrorMsg').show()
                        $('#idScriptErrorMsg').html(response.message)
                    }
                }
            });
        });

    });
    </script>
@endsection
