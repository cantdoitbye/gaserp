@extends('admin.layout.admin-app')
@section('title', 'Tour Package list')

@section('content')
<div class="container-fluid">
    <div class="py-4">
        <div class="d-sm-flex justify-content-between mb-3 mc-flex">
            <h2 class="page-title">Role & Permissions</h2>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                <thead>
                    <tr class="table-primary">
                    <th>Module</th>
                    <th>Admin</th>
                    <th>Sub Admin</th>
                    <th>Other</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Module 1: Dashboard -->
                    <!-- <tr>
                    <td>Dashboard</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="dashboard" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['dashboard']) && in_array('view', $adminpermissions['dashboard']) ? 'checked' : '' }}> View
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="dashboard" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['dashboard']) && in_array('view', $subadminpermissions['dashboard']) ? 'checked' : '' }}> View
                    </td>
                    <td>
                        <input type="checkbox"  class="permission-checkbox" data-page="dashboard" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['dashboard']) && in_array('view', $adminpermissions['dashboard']) ? 'checked' : '' }}> View
                    </td>
                    </tr> -->
                    <!-- Module 2: Accommodation Types -->
                    <tr>
                    <td>Accommodation Types</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="accommodation_types" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['accommodation_types']) && in_array('view', $adminpermissions['accommodation_types']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="accommodation_types" data-admin-id="1" data-permission="add" {{ isset($adminpermissions['accommodation_types']) && in_array('add', $adminpermissions['accommodation_types']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="accommodation_types" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['accommodation_types']) && in_array('view', $subadminpermissions['accommodation_types']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="accommodation_types" data-admin-id="2" data-permission="add" {{ isset($subadminpermissions['accommodation_types']) && in_array('add', $subadminpermissions['accommodation_types']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="accommodation_types" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['accommodation_types']) && in_array('view', $otheradminpermissions['accommodation_types']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="accommodation_types" data-admin-id="3" data-permission="add" {{ isset($otheradminpermissions['accommodation_types']) && in_array('add', $otheradminpermissions['accommodation_types']) ? 'checked' : '' }}> Add <br>
                    </td>
                    </tr>
                    <!-- Module 3: Destinations -->
                    <tr>
                    <td>Destinations</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="destinations" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['destinations']) && in_array('view', $adminpermissions['destinations']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="destinations" data-admin-id="1" data-permission="add" {{ isset($adminpermissions['destinations']) && in_array('add', $adminpermissions['destinations']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="destinations" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['destinations']) && in_array('view', $subadminpermissions['destinations']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="destinations" data-admin-id="2" data-permission="add" {{ isset($subadminpermissions['destinations']) && in_array('add', $subadminpermissions['destinations']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="destinations" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['destinations']) && in_array('view', $otheradminpermissions['destinations']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="destinations" data-admin-id="3" data-permission="add" {{ isset($otheradminpermissions['destinations']) && in_array('add', $otheradminpermissions['destinations']) ? 'checked' : '' }}> Add <br>
                    </td>
                    </tr>
                    <!-- Module 5: TourType -->
                    <tr>
                    <td>TourType</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_type" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['tour_type']) && in_array('view', $adminpermissions['tour_type']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_type" data-admin-id="1" data-permission="add" {{ isset($adminpermissions['tour_type']) && in_array('add', $adminpermissions['tour_type']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_type" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['tour_type']) && in_array('view', $subadminpermissions['tour_type']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_type" data-admin-id="2" data-permission="add" {{ isset($subadminpermissions['tour_type']) && in_array('add', $subadminpermissions['tour_type']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_type" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['tour_type']) && in_array('view', $otheradminpermissions['tour_type']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_type" data-admin-id="3" data-permission="add" {{ isset($otheradminpermissions['tour_type']) && in_array('add', $otheradminpermissions['tour_type']) ? 'checked' : '' }}> Add <br>
                    </td>
                    </tr>
                    <!-- Module 6: Visa Countries -->
                    <tr>
                    <td>Visa Countries</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_countries" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['visa_countries']) && in_array('view', $adminpermissions['visa_countries']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_countries" data-admin-id="1" data-permission="add" {{ isset($adminpermissions['visa_countries']) && in_array('add', $adminpermissions['visa_countries']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_countries" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['visa_countries']) && in_array('view', $subadminpermissions['visa_countries']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_countries" data-admin-id="2" data-permission="add" {{ isset($subadminpermissions['visa_countries']) && in_array('add', $subadminpermissions['visa_countries']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_countries" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['visa_countries']) && in_array('view', $otheradminpermissions['visa_countries']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_countries" data-admin-id="3" data-permission="add" {{ isset($otheradminpermissions['visa_countries']) && in_array('add', $otheradminpermissions['visa_countries']) ? 'checked' : '' }}> Add <br>
                    </td>
                    </tr>
                    <!-- Module 7: Visa Types -->
                    <tr>
                    <td>Visa Types</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_types" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['visa_types']) && in_array('view', $adminpermissions['visa_types']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_types" data-admin-id="1" data-permission="add" {{ isset($adminpermissions['visa_types']) && in_array('add', $adminpermissions['visa_types']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_types" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['visa_types']) && in_array('view', $subadminpermissions['visa_types']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_types" data-admin-id="2" data-permission="add" {{ isset($subadminpermissions['visa_types']) && in_array('add', $subadminpermissions['visa_types']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_types" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['visa_types']) && in_array('view', $otheradminpermissions['visa_types']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_types" data-admin-id="3" data-permission="add" {{ isset($otheradminpermissions['visa_types']) && in_array('add', $otheradminpermissions['visa_types']) ? 'checked' : '' }}> Add <br>
                    </td>
                    </tr>
                    <!-- Module 8: Tour Query -->
                    <tr>
                    <td>Tour Query</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_query" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['tour_query']) && in_array('view', $adminpermissions['tour_query']) ? 'checked' : '' }}> View
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tour_query" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['tour_query']) && in_array('view', $subadminpermissions['tour_query']) ? 'checked' : '' }}> View
                    </td>
                    <td>
                        <input type="checkbox"  class="permission-checkbox" data-page="tour_query" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['tour_query']) && in_array('view', $otheradminpermissions['tour_query']) ? 'checked' : '' }}> View
                    </td>
                    </tr>
                    <!-- Module 9: Customers -->
                    <tr>
                    <td>Customers</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="customers" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['customers']) && in_array('view', $adminpermissions['customers']) ? 'checked' : '' }}> View
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="customers" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['customers']) && in_array('view', $subadminpermissions['customers']) ? 'checked' : '' }}> View
                    </td>
                    <td>
                        <input type="checkbox"  class="permission-checkbox" data-page="customers" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['customers']) && in_array('view', $otheradminpermissions['customers']) ? 'checked' : '' }}> View
                    </td>
                    </tr>
                    <!-- Module 10: Tours -->
                    <tr>
                    <td>Tours</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tours" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['tours']) && in_array('view', $adminpermissions['tours']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="tours" data-admin-id="1" data-permission="add" {{ isset($adminpermissions['tours']) && in_array('add', $adminpermissions['tours']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tours" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['tours']) && in_array('view', $subadminpermissions['tours']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="tours" data-admin-id="2" data-permission="add" {{ isset($subadminpermissions['tours']) && in_array('add', $subadminpermissions['tours']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="tours" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['tours']) && in_array('view', $otheradminpermissions['tours']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="tours" data-admin-id="3" data-permission="add" {{ isset($otheradminpermissions['tours']) && in_array('add', $otheradminpermissions['tours']) ? 'checked' : '' }}> Add <br>
                    </td>
                    </tr>
                    <!-- Module 10: Visa Applications -->
                    <tr>
                    <td>Visa Applications</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_applications" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['visa_applications']) && in_array('view', $adminpermissions['visa_applications']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_applications" data-admin-id="1" data-permission="add" {{ isset($adminpermissions['visa_applications']) && in_array('add', $adminpermissions['visa_applications']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_applications" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['visa_applications']) && in_array('view', $subadminpermissions['visa_applications']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_applications" data-admin-id="2" data-permission="add" {{ isset($subadminpermissions['visa_applications']) && in_array('add', $subadminpermissions['visa_applications']) ? 'checked' : '' }}> Add <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_applications" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['visa_applications']) && in_array('view', $otheradminpermissions['visa_applications']) ? 'checked' : '' }}> View <br>
                        <input type="checkbox" class="permission-checkbox" data-page="visa_applications" data-admin-id="3" data-permission="add" {{ isset($otheradminpermissions['visa_applications']) && in_array('add', $otheradminpermissions['visa_applications']) ? 'checked' : '' }}> Add <br>
                    </td>
                    </tr>
                    <!-- Module 11: User Visa Applications -->
                    <tr>
                    <td>User Visa Applications</td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="user_visa_applications" data-admin-id="1" data-permission="view" {{ isset($adminpermissions['user_visa_applications']) && in_array('view', $adminpermissions['user_visa_applications']) ? 'checked' : '' }}> View <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="user_visa_applications" data-admin-id="2" data-permission="view" {{ isset($subadminpermissions['user_visa_applications']) && in_array('view', $subadminpermissions['user_visa_applications']) ? 'checked' : '' }}> View <br>
                    </td>
                    <td>
                        <input type="checkbox" class="permission-checkbox" data-page="user_visa_applications" data-admin-id="3" data-permission="view" {{ isset($otheradminpermissions['user_visa_applications']) && in_array('view', $otheradminpermissions['user_visa_applications']) ? 'checked' : '' }}> View <br>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pagescript')
<script>
    $(document).on('change', '.permission-checkbox', function() {
        var page = $(this).data('page');
        var adminId = $(this).data('admin-id');
        var permissionType = $(this).data('permission');
        var isChecked = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: globalSiteUrl + "/admin/update-permission",
            method: 'POST',
            data: {
                admin_id: adminId,
                page: page,
                permission: permissionType,
                value: isChecked
            },
            success: function(response) {
                console.log('Permission updated successfully');
            },
            error: function(response) {
                console.log('Error updating permission');
            }
        });
    });
</script>
@endsection