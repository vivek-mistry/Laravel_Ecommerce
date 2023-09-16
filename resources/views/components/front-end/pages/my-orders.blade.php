@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container my-5">
        <div class="row py-5">
            @include('components.front-end.common.account-sidebar')
            <div class="col-md-9 px-lg-4 pr-0">
                <h3 class="font-28 font-bold mb-4">My Orders </h3>
                <div class="table-responsive">
                    <table id="example" class="table font-18" style="width:100%">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Order Total</th>
                                <th>Status</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $key => $order)
                                <tr>
                                    <td>#{{ $order->order_number }}</td>
                                    <td>{{ setDateFormat($order->created_at) }}</td>
                                    <td>${{ $order->net_amount }}</td>
                                    <td>{{ isset($order->current_order_status->status) ? $order->current_order_status->status : '---' }}
                                    </td>
                                    <td>
                                        <a href="#" class="view_order" data-id="{{ $order->id }}">View Order</a>
                                        
                                    </td>
                                    <td>
                                        <a href="{{ url('order/'.$order->id) }}" target="_blank">View Invoice</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        No orders
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="font-18">1 Item</p>
                    <div class="d-flex align-items-center font-18">
                        <span>Show </span>
                        <select name="items" class="mx-2">
                            <option selected="">10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span>per page</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.front-end.popups.view-order-list')
@endsection

@section('scripts')
    <script>
        $(".view_order").on('click', function() {
            openModel("view-order-detail");
            var order_id = $(this).data('id');
            var end_point = FRONTEND_BASEURL + '/order/detail/'+order_id;
            $.ajax({
                url: end_point,
                type: "GET",
                dataType: 'json',
                async: false,
                success: function(response) {
                    $(".view-order-detail-body").html(response.html);
                    $(".view_order_title").text("ORDER: #"+response.order.order_number);
                    $(".net_amount").text("$"+response.order.net_amount);
                }
            });
        });
    </script>
@endsection
