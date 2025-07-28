@extends('admin.layout.admin-app')
@php
    // Fetch the authenticated admin's permissions
    $permissions = json_decode(Auth::guard('admin')->user()->permissions, true);
@endphp
@section('content')
    <div class="container-fluid">
        <div class="py-4">
            <div class="d-sm-flex justify-content-between mb-3 mc-flex">
                <h2 class="page-title">{{ isDeleted() }}  Visa types (<span id="total_record"></span>)</h2>
                @if (isset($permissions['visa_types']) && in_array('add', $permissions['visa_types']))
                <button class="btn btn-primary mw-100" id="create_new_visa_types">Add
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
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php $deleted_text = "View deleted visa types"; ?>
            @include('admin.datatable.restore_button')
        </div>
    </div>
    @include('admin.master-data.visa-types.add')
    <input type="hidden" name="deleted" id="deleted" value="{{$deleted}}">
@endsection
@section('pagescript')
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
                    url: globalSiteUrl + "/admin/master/visa-types",
                    data: function (data) {
                        data.deleted = $('#deleted').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', sortable: false},
                ],
                "drawCallback": function (settings) {
                    $('#total_record').html(settings.json.recordsTotal)
                    $('#deletedRecord').html(settings.json.deletedRecord)
                    $('.visa_types_count').html(settings.json.recordsTotal)
                }
            });

            $('#visa_types_from').validate({
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
                },
                messages: {
                    name: {
                        required: "Name field is required.",
                    },
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-error').append(error);
                }
            });

        });

        //for Add Model
        $(document).on('click', '#create_new_visa_types', function () {
            $('label.error').hide();
            $('#visa_types_id').val('');
            $('#visa_types_from').trigger("reset");
            $('#modelHeaderTitle').html("Add visa types");
            $('#editModal').modal('show');
        });

        //for Edit Model
        $(document).on('click', '.editRow', function () {
            let id = $(this).data('id');
            $.get(globalSiteUrl + "/admin/master/visa-types/edit/" + id, function (data) {
                $('label.error').hide();
                $('*').removeClass('error');
                $('#modelHeaderTitle').text('Edit visa types');
                $('#editModal').modal('show');
                $('#visa_types_id').val(data.id);
                $('#name').val(data.name);
            });
        });

        $(document).on('submit', '#visa_types_from', function (e) {
            e.preventDefault();
            let form = $(this);
            if (form.valid()) {
                buttonDisabled('#saveBtn');
                $.ajax({
                    data: form.serialize(),
                    url: globalSiteUrl + "/admin/master/visa-types/add",
                    type: "POST",
                    dataType: 'json',
                    success: function (result) {
                        $('.alert').hide();
                        $('#visa_types_from').trigger("reset");
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

            $('#deleteModalHeading').html('Delete visa types');
            $('#deleteBtn').html('Delete')
            $('#deleteContent').html('Are you sure you want to delete <span id="deleteNameLabel" class="text-primary">' + name + '</span> visa types?')
            if (type == 2) {

                $('#deleteModalHeading').html('Restore visa types');
                $('#deleteBtn').html('Restore')
                $('#deleteContent').html('Are you sure you want to restore <span id="deleteNameLabel" class="text-primary">' + name + '</span> visa types?')
            }
            if (type == 3) {
                $('#deleteModalHeading').html('Permanent Delete Machine');
                $('#deleteContent').html('Are you sure you want to permanent delete <span id="deleteNameLabel" class="text-primary">' + name + '</span> visa types?')
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
    </script>
@endsection
