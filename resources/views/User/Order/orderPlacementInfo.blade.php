@extends('layouts.user.layout')
@section('title')
    <title>Address</title>
@endsection
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h3>Checkout Address</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="checkout">
        <div class="container">
            <h3 id="lead"></h3>
            <div id="tab-con">

                <div class="col-md-9 checkout-left-basket" data-wow-delay=".5s">
                    <form method="post" action="">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a style="border:1px solid white; background-color: #FDA30E; border-radius: 0; padding:1em; font-size: 1.25em" href="javascript:void(0);">Address</a>
                            </li>
                            <li class="disabled"><a style="border:1px solid white; background-color: #F8F3F9; border-radius: 0; padding:1em; font-size: 1.25em" href="javascript:void(0);">Payment Method</a>
                            </li>
                            <li class="disabled" style="border-top: none"><a style="border:1px solid white; background-color: #F8F3F9; border-radius: 0; padding:1em; font-size: 1.25em" href="javascript:void(0);">Order Review</a>
                            </li>
                        </ul>
                        <div class="col-md-12 newsright">
                            <label for="firstname">Address</label>
                            <textarea id="address"  placeholder="Address" rows="5" required>{{Auth::user()->address}}</textarea>
                        </div>
                        <div class="col-md-4 newsright">
                            <label for="company">Email</label>
                            <input id="email" type="email" required value="{{Auth::user()->email}}">
                        </div>
                        <div class="col-md-4 newsright">
                            <label for="street">Phone No</label>
                            <input id="phone" type="text" id="Phone" required value="{{Auth::user()->mobile}}">
                        </div>
                        <div class="col-md-4 newsright">
                        <label for="state">District</label>
                            <select id="city" autocomplete="on" required>
                                <option value="">Select City</option>
                                @foreach($Districts as $item)
                                    <option value="{{trim($item)}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-offset-8 col-md-4 newsright" data-wow-delay=".5s">
                                <input type="submit" value="Proceed To Payment">
                        </div>
                    </form>
                </div>
                <div class="col-md-3" data-wow-delay=".5s">
                    <div class="checkout-left-basket animated wow slideInLeft" >
                        <h4>Order Summary</h4>
                        <ul>
                            <li>Order Subtotal <i>-</i> <span id="final-total"></span></li>
                            <li>Shipping and Handling <i>-</i> <span>{{$shipping_cost}} tk</span></li>
                            <li>Total <i>-</i> <span id="totalWithShipping"></span></li>
                        </ul>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            var dis = '{{trim(Auth::user()->district)}}';
            $('#city').val(dis);
            var voucher = JSON.parse(localStorage.getItem('productId'));
            var subTotal = 0;
            var total = 0
            for(var i = 0; i < voucher.length; i++) {
                var unitPrice = parseFloat(voucher[i].price);
                console.log(voucher[i].weight);
                var discount = ((unitPrice)*parseFloat(voucher[i].quantity))-(Math.ceil(unitPrice*parseFloat(voucher[i].discount)*parseFloat(voucher[i].quantity)/100));
                subTotal = Math.ceil(subTotal+discount);
            }
            var shippingCost = parseFloat({{$shipping_cost}});
            total = (Math.ceil((subTotal+shippingCost)/5))*5;
            $('#final-total').text(subTotal+' tk');
            $('#totalWithShipping').text(total+' tk');
            $('form').submit(function (event) {
                event.preventDefault();
                var voucher = JSON.parse(localStorage.getItem('productId'));
                $('#final-total').text(subTotal+' tk');
                $('#totalWithShipping').text(total+' tk');
                var userId = "{{ $userId->id }}";
                var orderInfo = [];
                orderInfo.push({
                    'userId' : userId,
                    'address':$('#address').val(),
                    'phone' : $('#phone').val(),
                    'email':$('#email').val(),
                    'city' : $('#city').val(),
                    'productDetail' : voucher
                });
                localStorage.setItem('voucher',JSON.stringify(orderInfo));
                window.location.href = '/orderPlacementInfo/payment';
            })
        })
    </script>
    @endsection