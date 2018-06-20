@extends('layouts.user.layout')
@section('title')
    <title>Order Track</title>
@endsection
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h3>Track Your Order</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="checkout">
        <div class="container">
            <div class="col-md-12 table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
                <h3 style="font-size: 1.1em">If you have any questions, please feel free to <a href="/contact">contact us</a>, our customer service center is working for you 24/7.</h3>
                <div class="col-md-12 prd_con" style="margin-bottom: 20px;">
                    <h3>Current status of your order</h3>
                    @if($order['status'] == 'Cancelled')
                        <div class="col-md-3" style="text-align: center;">
                            <i class="fa fa-times fa-5x tracking" aria-hidden="true"></i><br>
                            <h4 style="color:orange;">Order Cancelled</h4>
                        </div>
                    @else
                        <div class="col-md-3">
                            <i class="fa fa-cogs fa-5x tracking" aria-hidden="true"></i><br>
                            <h4 style="color:orange;">Processing</h4>
                        </div>
                        <div class="col-md-3">
                            @if($order['status'] == 'Confirmed' || $order['status'] == 'Shipping' ||$order['status'] == 'Delivered')
                                <i class="fa fa-handshake-o fa-5x tracking" aria-hidden="true"></i><br>
                                <h4 style="color: orange">Confirmed</h4>
                            @else
                                <i class="fa fa-handshake-o fa-5x" aria-hidden="true"></i><br>
                                <h4>Confirmed</h4>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if($order['status'] == 'Shipping' ||$order['status'] == 'Delivered')
                                <i class="fa fa-truck fa-5x tracking" aria-hidden="true"></i><br>
                                <h4 style="color:orange">Shipping</h4>
                            @else
                                <i class="fa fa-truck fa-5x" aria-hidden="true"></i><br>
                                <h4>Shipping</h4>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if($order['status'] == 'Delivered')
                                <i class="fa fa-check-square-o fa-5x tracking" aria-hidden="true"></i><br>
                                <h4 style="color:orange">Delivered</h4>
                            @else
                                <i class="fa fa-check-square-o fa-5x" aria-hidden="true"></i><br>
                                <h4>Delivered</h4>
                            @endif
                        </div>
                    @endif

                </div>
                <table class="timetable_sub">
                    <thead>
                    <tr class="cart_menu">
                        <th>Order ID</th>
                        <th>Issued Date</th>
                        <th class="image">Item</th>
                        <th class="description">Details</td>
                        <th class="price">Quantity</th>
                        <th class="quantity">Unit Price</th>
                        <th class="quantity">Discount</th>
                        <th class="quantity">Unit Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $subtotal =0;
                    $totalDiscount = 0;
                    ?>
                    @foreach($order['order_product'] as $item)
                        <tr>
                            <td class="cart_description">
                                {{$item['order_number']}}
                            </td>
                            <td class="cart_description">
                                {{ substr($order['created_at'], 0, strpos($order['created_at'], ' '))}}
                            </td>
                            <td class="cart_product">
                                <a href=""><img style="height: 110px; width: 110px;" src="{{$item->photo}}" alt="Image Not Found"></a>
                            </td>
                            <td class="cart_description">
                                <h4>{{$item->title}}</h4>
                                @if($item->size)
                                    <p><span>Size: </span>{{$item->size}}</p>
                                @endif
                                @if($item->color)
                                    <p><span>Color:</span> <span style="color: {{$item->color}}; background-color: {{$item->color}}">pp</span><span> {{$item->color}} </span></p>
                                @endif
                            </td>
                            <td class="cart_price">
                                <p>{{$item->quantity}}</p>
                            </td>
                            <td class="cart_quantity">
                                <p>{{$item->unit_price}} tk</p>
                            </td>
                            <td class="cart_quantity">
                                <p>
                                    <?php
                                    $totalDiscount = ceil(floatval($item->quantity)*(floatval($item->unit_price)-floatval($item->weight))*floatval($item->discount)/100);
                                    echo $totalDiscount.' tk';
                                    ?>
                                </p>
                            </td>
                            <td class="cart_quantity">
                                <p>
                                    <?php
                                    $subtotal = $subtotal+(intval($item->quantity)*intval($item->unit_price))-$totalDiscount;
                                    echo ($subtotal." tk");
                                    ?>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table><br>
                <div class="col-md-12 prd_con" style="padding-top: 20px; margin-bottom: 25px; border-top: 2px solid #38a7bb; box-shadow: 0px 2px 3px #CCC;">
                    <div class="col-md-4">
                        <address>
                            <h4>Shipping Address</h4>
                            <span class="order_info">{{Auth::user()->name}}</span><br>
                            <span class="order_info">{{$order['address']}}</span><br>
                            <span class="order_info">City: {{$order['city']}}</span><br>
                            <span class="order_info">Division: {{$order['division']}}</span><br>
                            <span class="order_info">Phone: {{$order['phone']}}</span><br>
                            <span class="order_info">Email: {{$order['email']}}</span>

                        </address>
                    </div>
                    <div class="col-md-4">
                        <h4>Order Summary</h4>
                        <span class="left order_info">Sub Total</span>
                        <span class="right order_info">{{$subtotal}} tk</span><br>
                        <span class="left order_info">Total Discount</span>
                        <span class="right order_info">{{$totalDiscount}} tk</span><br>
                        <span class="left order_info">Delivery and handling</span>
                        <span class="right order_info">{{$order->shipping_cost}} tk</span><br>
                        <span class="left order_info">Total</span>
                        <span class="right order_info">
                            <?php
                            $total = ($subtotal-floatval($order['used_point']));
                            $total = $total+floatval($order->shipping_cost);
                            echo ceil((ceil($total/5))*5);
                            ?> tk
                        </span>
                    </div>
                    <div class="col-md-4">
                        <h4>Payment Method</h4>
                        <span class="order_info">
                            {{$order->payment_methode}}
                            <i class="fa fa-handshake-o tracking"></i>
                        </span>
                        <br>
                        <h4>Curretnt Status</h4>
                        <span class="order_info">
                        @if($order['status'] == 'Invoice' || $order['status'] == 'Shipping' || $order['status'] == 'Processing-Delivery')
                                Processing
                            @else
                                {{$order['status']}}
                            @endif
                    </span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection