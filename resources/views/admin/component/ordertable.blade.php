<div class="table-responsive admin-responsive lr_table">
                    <table class="table table-striped tablesaw tablesaw-stack " data-tablesaw-mode="stack"
                           id="roleTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            @php
    $currentRoute=request()->route()->getName();

@endphp 
                               @if($currentRoute == 'admin.payouts.list')
                               <th>Date</th>
                               <th>Time</th>

                               <th>Order#</th>

                                <th>Requester</th>
                              
                                <th>Amount</th>
                                <th>Payouts Types</th>
                                <th> Status</th>
                                {{-- <th>Action</th> --}}
                               @else
                                <th>Date.</th>
                                <th>Order#</th>
                                <th>Title</th>
                                <th>Requester</th>
                                <th>Deliver Partner</th>
                                <th>Subtotal</th>
                                <th>Taxes</th>
                                <th>Final Amount</th>
                                <th>Payment Method</th>
                                <th>Rating</th>
                                <th>Order Status</th>
                                <th>Action</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>