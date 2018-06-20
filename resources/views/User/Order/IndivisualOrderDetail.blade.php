@extends('layouts.user.layout')
@section('title')
    <title>Order Detail</title>
@endsection
@section('content')
    <section style="margin-top: 25px;">
        <div class="container">
            <div class="col-md-12 prd_con" style="padding-top: 20px; margin-bottom: 25px; border-top: 2px solid #38a7bb; box-shadow: 0px 2px 3px #CCC;">
                <div class="col-md-4">
                    <address>
                        <h4>Shipping Address</h4>
                        <span>{{Auth::user()->name}}</span><br>
                        <span>{{$order['address']}}</span><br>
                        <span>City: {{$order['city']}}</span><br>
                        <span>Division: {{$order['division']}}</span><br>
                        <span>Phone: {{$order['phone']}}</span><br>
                        <span style="color: #38a7bb">Email: {{$order['email']}}</span>

                    </address>
                </div>
                <div class="col-md-4">
                    <h4>Payment Method</h4>
                    <div>
                    {{$order->payment_methode}}
                    <i class="fa fa-handshake-o tracking"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Curretnt Status</h4>
                    <span>
                        @if($order['status'] == 'Invoice' || $order['status'] == 'Shipping' || $order['status'] == 'Processing-Delivery')
                            Processing
                            @else
                            {{$order['status']}}
                        @endif
                    </span>
                </div>
            </div>
                <div class="clearfix"></div>
                <div class="table-responsive table-bordered">
                    <table class="table table-condensed tc">
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
                                    {{$order['order_number']}}
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
                    </table>
                </div>
                <div class="box">
                    <div class="table-responsive">
                        <div class="col-sm-offset-8 col-sm-4">
                            <table class="table table-hover">
                                <tr>
                                    <td>Sub Total</td>
                                    <td>{{$subtotal}} tk</td>
                                </tr>
                                <tr>
                                    <td>Total Discount</td>
                                    <td>{{$totalDiscount}} tk</td>
                                </tr>
                                @if(intval($order['used_point'])>0)
                                    <tr>
                                        <td>Point Usage Discount</td>
                                        <td>{{$order['used_point']}} tk</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Delivery and handling</td>
                                    <td>{{$order->shipping_cost}} tk</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?php

                                        $total = ($subtotal-floatval($order['used_point']));
                                        $total = $total+floatval($order->shipping_cost);
                                        echo ceil((ceil($total/5))*5);
                                        ?> tk
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!--/#cart_items-->
    </section>
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