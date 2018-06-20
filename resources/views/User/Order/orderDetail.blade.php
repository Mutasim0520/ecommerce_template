@extends('layouts.user.layout')
@section('title')
    <title>Order List</title>
@endsection
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h3>My Orders</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="checkout">
        <div class="container">
            <div class="col-md-12 table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
                <h3 style="font-size: 1.1em">If you have any questions, please feel free to <a href="/contact">contact us</a>, our customer service center is working for you 24/7.</h3>
                @if(sizeof($order)>0)
                    <table class="timetable_sub">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Track Order</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $n = 1; ?>
                    @foreach($order as $item)
                        <tr>
                            <td class="">
                                {{$n}}
                            </td>
                            <td class="">
                                {{$item['order_number']}}
                            </td>
                            <td class="">
                                {{ substr($item['created_at'], 0, strpos($item['created_at'], ' '))}}
                            </td>

                            <td class="cart_price">
                                <p>{{floor($item->order_value)}} tk</p>
                            </td>
                            <td>
                                <a class="normal-links" href="/indivisualOrderTrack/{{encrypt($item->order_id)}}"><i class="fa fa-eye" style="margin-right: 2px;"></i>Track Order
                                </a>
                            </td>
                        </tr>
                        <?php $n++;?>
                    @endforeach
                    </tbody>
                </table>
                    @else
                    <h3 style="font-size: 1.1em">Yo have not done any shopping from us yet</h3>
                    <center><a>h</a></center>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function showDetail(id) {
            $('#detail_'+id+'').toggle(function () {
                $(this).css("background-color","#F8F8F8");
                $(this).css("background-color","#F8F8F8");
            });
        }
    </script>
@endsection