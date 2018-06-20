@extends('layouts.layout')
@section('header')
    Order Detail
@endsection
@section('content')
    <div class="col-sm-12 main">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div id="invoice" class="panel-body">
                        <div class="col-xs-12">
                            <div class="invoice-title">
                                <h3>Order ID:{{$Order->order_number}}</h3>
                                <span class="pull-right"><button class="btn btn-default" onclick="myFunction()">Print</button></span>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{$Order['user']->name}}<br>
                                        {{$Order['address']}}<br>
                                        <strong>Division: </strong>{{$Order['division']}}<br>
                                        <strong>City: </strong>{{$Order['city']}}
                                    </address>
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        <?php echo date("jS F Y", strtotime($Order['created_at'])); ?><br><br>
                                    </address>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <address>
                                                <strong>Shipped To:</strong><br>
                                                {{$Order['user']->name}}<br>
                                                {{$Order['address']}}<br>
                                                <strong>Division: </strong>{{$Order['division']}}<br>
                                                <strong>City: </strong>{{$Order['city']}}
                                            </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <address>
                                        <strong>Company Info:</strong><br>
                                        Name<br>
                                    </address>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <address>
                                        <strong>Payment Method:</strong><br>
                                        {{$Order['payment_methode']}}<br>
                                        {{$Order['email']}}
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                            <td><strong>Item</strong></td>
                                                            <td class="text-center"><strong>Unit Price</strong></td>
                                                            <td class="text-center"><strong>Quantity</strong></td>
                                                            <td class="text-center"><strong>Total Discount</strong></td>
                                                            <td class="text-right"><strong>Unit Totals</strong></td>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($Order['order_product'] as $item)
                                                    <tr>
                                                        <td>{{$item->title}}</td>
                                                        <td class="text-center">{{$item->unit_price}}</td>
                                                        <td class="text-center">{{$item->quantity}}</td>
                                                        <td class="text-center"><?php
                                                            if($item->discount){
                                                                $discount = ceil((floatval($item->discount)/100)*(floatval($item->unit_price)-floatval($item->weight))*intval($item->quantity));
                                                                echo $discount;
                                                            }
                                                            else{
                                                                $discount=0;
                                                                echo $discount;
                                                            }
                                                            ?> tk</td>
                                                        <td class="text-right"><?php
                                                            $unitTotal = (floatval($item->quantity)*floatval($item->unit_price))-floatval($discount);
                                                            echo $unitTotal;
                                                            ?> tk
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                                        <td class="thick-line text-right">{{ceil($Order->order_value)}} tk</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="no-line text-center"><strong>Shipping Cost</strong></td>
                                                        <td class="no-line text-right">{{$Order->shipping_cost}} tk</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="no-line text-center"><strong>Total</strong></td>
                                                        <td class="no-line text-right"> <?php echo ceil(floatval($Order->order_value))?> tk</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
@endsection