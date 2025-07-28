@extends('admin.layout.admin-app')
@section('title', 'Contact Us Query List')

@section('content')
<div class="container-fluid">
    <div class="py-4">
        <div class="d-sm-flex justify-content-between mb-3 mc-flex">
            <h2 class="page-title">{{ isDeleted() }} Contact Us Query List (<span id="total_record"></span>)</h2>
            <!-- <div>
                    <div id="reportrange" class="dateFilter">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <label id="dtLabel" class="mb-0"></label> (<span></span>) <i class="fas fa-chevron-down"></i>
                        <input type="hidden" name="filterStartDate"
                               value="{{ $filterStartDate }}" id="filterStartDate">
                        <input type="hidden" name="filterEndDate"
                               value="{{ $filterEndDate }}" id="filterEndDate">
                    </div>
                </div> -->
                {{-- <a class="btn btn-primary" id="filterBtn"><i class="bi bi-filter"></i> Filter</a> --}}

        </div>
        <!-- filter start  -->
        @include('admin.filter.table')


        <!-- filter end  -->
        <div class="card admin-card mb-4">
            @include('admin.errors.javascript_message_error_success')
            @include('admin.errors.message_error_success')
            <div class="card-body">
                <div class="table-responsive admin-responsive lr_table">
                    <table class="table table-striped tablesaw tablesaw-stack " data-tablesaw-mode="stack"
                           id="roleTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Name</th>
                                <th>Phone No.</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    </div>
</div>


<input type="hidden" name="label" id="label" value="{{ $label }}">

<input type="hidden" name="deleted" id="deleted" value="{{$deleted}}">
@endsection
@section('pagescript')
<script>
    var table = $('#roleTable');
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

        table.DataTable({
            "scrollX": true,
            processing: true,
            serverSide: true,
            "order": [[0, "asc"]],
            "bAutoWidth": false, // Disable the auto width calculation
            ajax: {
                url: globalSiteUrl + "/admin/contact-query-list",
                data: function (data) {
                    data.deleted = $('#deleted').val();
                    data.filterStartDate = $('#filterStartDate').val();
                data.filterEndDate = $('#filterEndDate').val();
                }
            },
            columns: [

            {
            data: null, // We use null because we will calculate it ourselves
            name: 'sr_no',
            sortable: false,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1; // Display row index + starting point of the current page
            }
        },                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'subject', name: 'subject'},
                {data: 'message', name: 'message'},
                {data: 'created_at', name: 'created_at'},
            ],
            "drawCallback": function (settings) {
                $('#total_record').html(settings.json.recordsTotal)
                $('#deletedRecord').html(settings.json.deletedRecord)
                $('.role_count').html(settings.json.recordsTotal)
            }
        });


      


    });

    
    //Delete Function for DataTable
    

    
      
       
    //for Edit Model
  
    var label = $('#label').val();


      



$(function () {
    var start = moment($('#filterStartDate').val());
    var end = moment($('#filterEndDate').val());

    function cb(start, end, label) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#filterStartDate').val(start.format('YYYY-MM-DD'));
        $('#filterEndDate').val(end.format('YYYY-MM-DD'));
        $('#dtLabel').html(label);
        $('#label').val(label);
        console.log(label);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        opens: 'left',
        ranges: globalDate
    }, cb);
    cb(start, end, label);
});

// $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
//     change_parameter();
//     location.reload();
// });


function change_parameter() {
    filterStartDate = $("#filterStartDate").val();
    filterEndDate = $("#filterEndDate").val();
    label = $("#label").val();
    url_update = '?filterStartDate=' + filterStartDate;
    url_update += '&filterEndDate=' + filterEndDate;
    url_update += '&label=' + label;
    //window.history.replaceState(null, null, url_update);
    window.history.pushState(null, null, url_update);
}

  
   

   

   
    
</script>
@endsection
