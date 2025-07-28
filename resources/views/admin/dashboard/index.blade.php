@extends('admin.layout.admin-app')
@section('content')
@php 

$admin = \Auth::guard('admin')->user();


@endphp
    <div class="container-fluid">
        <div class="py-4">
                          

            <div class="d-sm-flex justify-content-between mb-3">
                <h2 class="page-title">Dashboard</h2>
                <div>
                    @if($admin->role === 1)
                    <div id="reportrange" class="dateFilter">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <label id="dtLabel" class="mb-0"></label> (<span></span>) <i class="fas fa-chevron-down"></i>
                        <input type="hidden" name="filterStartDate"
                               value="{{ $filterStartDate }}" id="filterStartDate">
                        <input type="hidden" name="filterEndDate"
                               value="{{ $filterEndDate }}" id="filterEndDate">
                    </div>
                    @endif
                </div>
            </div>
            @if($admin->role === 1)
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-1 border-0 shadow text-custom mb-4" style="background: #F99BAB66;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="total_count">
                                    <a href="{{ route('admin.users') }}"
                                       class="h3">{{ $total_users }}</a>
                                       <h4 class="h5 mt-3">Total Users</h4>

                                </div>
                                <div class="dash-circle">
                                <img src="{{url('/')}}/assets/img/icons/pendingorder.svg" alt="Pending"/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
               

               

               
            
             

             
             
              
              
      
             
             
             
               
             
               
               
            </div>

            <div class="row row-padding">
              
              

            
            </div>
            @endif
        </div>
    </div>
    <input type="hidden" name="label" id="label" value="{{ $label }}">
@endsection
@section('pagescript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script>
     

    

        $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
            change_parameter();
            location.reload();
        });


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
