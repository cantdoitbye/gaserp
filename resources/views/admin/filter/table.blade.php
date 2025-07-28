<div class="card filter-bar border-0" id="filterBar">
            <form id="formFilter" method="get">
                <input type="hidden" id='typeText' value="">
                <input type="hidden" name="type" id="type" value="">

                <input type="hidden" name="filterStartDate"
                       value="{{ $filterStartDate }}" id="filterStartDate">
                <input type="hidden" name="filterEndDate"
                       value="{{ $filterEndDate }}" id="filterEndDate">

                <input type="hidden" name="label" id="label" value="{{ $label }}">

                <div class="filter-header card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"> Filter</h5>
                    <a href="javascript:;" class="btn btn-light filter-close" aria-label="Close"><i
                            class="fas fa-times"></i></a>
                </div>
                <div class="filter-body card-body">
                   
                    <div class="mb-3">
                        <label class="form-lable mb-1">Date</label>
                        <div id="reportrange" class="dateFilter text-truncate">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <label id="dtLabel" class="mb-0"></label> (<span></span>)
                        </div>
                    </div>
                    @php

                    $currentRoute=request()->route()->getName();
                  

                    @endphp 
                                                   @if($currentRoute === 'admin.payouts.list' || $currentRoute === 'admin.orders.list')
                           
                    {{-- @if(Route::currentRouteName() === 'admin.orders.list' || 'admin.payouts.list') --}}
            <div class="mb-3">
                <label class="form-lable mb-1">Status</label>
                <select class="form-control form-control-admin bg-white" name="filterStatus" id="filterStatus">
                    <option value="">All</option>
                    <option value="6" @if($filterStatus==6) selected @endif>Delivered</option>
                    <option value="1" @if($filterStatus==1) selected @endif>Cancelled</option>
                    <option value="2" @if($filterStatus==2) selected @endif>Pending</option>
                    <option value="3" @if($filterStatus==3) selected @endif>Active</option>
                </select>
            </div>
            @endif

            @if(Route::currentRouteName() === 'admin.partners.list')

            <div class="mb-3">
                        <label class="form-lable mb-1">Status</label>
                        <select class="form-control form-control-admin bg-white" name="filterStatus" id="filterStatus">
                            <option value="">All</option>
                            <option value="1" @if($filterStatus==1) selected @endif>Active</option>
                            <option value="0" @if($filterStatus==0) selected @endif>Inactive</option>
                        </select>
                    </div>
                    @endif



                  
                </div>


                <div class="filter-Footer card-footer text-center">
                    <div class="row align-items-center">
                        <div class="col">
                            <a href="{{ route(Route::currentRouteName()) }}"
                               class="btn btn-dark w-100">Clear</a>
                        </div>
                        <div class="col">
                            <button type="submit" onClick="" class="btn btn-primary w-100">Apply</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>