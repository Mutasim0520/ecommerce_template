@extends('layouts.user.layout')
@section('title')
    <title>Order Payment</title>
@endsection
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h3>Checkout Payment</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="checkout" style="display: none">
        <div class="container">
            <h3 id="lead"></h3>
            <div id="tab-con">

                <div class="col-md-9 checkout-left-basket" data-wow-delay=".5s">
                    <ul class="nav nav-pills nav-justified">
                            <li><a style="color: white; border:1px solid white; background-color: #FDA30E; border-radius: 0; padding:1em; font-size: 1.25em" href="javascript:void(0);">Address</a>
                            </li>
                            <li class="active"><a style="border:1px solid white; background-color: #FDA30E; border-radius: 0; padding:1em; font-size: 1.25em" href="javascript:void(0);">Payment Method</a>
                            </li>
                            <li class="disabled" style="border-top: none"><a style="border:1px solid white; background-color: #F8F3F9; border-radius: 0; padding:1em; font-size: 1.25em" href="javascript:void(0);">Order Review</a>
                            </li>
                        </ul>
                    <form method="post" action="javascript:callAjax();">
                        <div class="col-sm-6">
                            <div class="ert">
                                <label class="radio" style="margin: 1em 0 0 0"><input type="radio" name="payment" value="bikash" required><i></i>Mobile Banking</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="ert">
                                <label class="radio" style="margin: 1em 0 0 0"><input type="radio" name="payment" value="Bank Transfer" required><i></i>Bank Transfer</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="ert">
                                <label class="radio" style="margin: 1em 0 0 0"><input type="radio" name="payment" value="Money Delivered Personal" required><i></i>Money Delivered Personally</label>
                            </div>
                        </div >
                        <div class="col-sm-6">
                            <div class="ert">
                                <label class="radio" style="margin: 1em 0 0 0"><input type="radio" name="payment" value="Cash On Delivery" required><i></i>Cash On Delivery</label>
                            </div>
                        </div >
                        <div class="col-md-offset-10 col-md-2 newsright" data-wow-delay=".5s">
                            <input type="submit" value="Proceed">
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
        $('input[name=payment]').change(function () {
            if($('input[name=payment]:checked').val()=="Other"){
                $('input[name=other_method]').attr('required',true);
            }
            else{
                $('input[name=other_method]').attr('required',false);
            }
        });
        $(document).ready(function () {
            var voucher = JSON.parse(localStorage.getItem('voucher'));
            if(voucher){
                $('.checkout').show();
            }
            else {
                window.location.replace('/cart');
            }
            var subTotal = 0;
            var total = 0;
            var products = voucher[0].productDetail;
            for(var i = 0; i < products.length; i++) {
                var unitPrice = parseFloat(products[i].price);
                var discount = ((unitPrice)*parseFloat(products[i].quantity))-(Math.ceil((unitPrice)*parseFloat(products[i].discount)*parseFloat(products[i].quantity)/100));
                subTotal = Math.ceil(subTotal+discount);
            }
            var shippingCost = parseFloat({{$shipping_cost}});
            total = (Math.ceil((subTotal+shippingCost)/5))*5;

            $('#final-total').text(subTotal+' tk');
            $('#totalWithShipping').text(total+' tk');
        });

        function callAjax() {
            var paymentMethode =$('input[name=payment]:checked').val();
            if(paymentMethode == 'Other'){
                var definendMethode = $('input[name=other_method]').val();
                localStorage.setItem('payment_methode', paymentMethode);
                localStorage.setItem('defined_methode', definendMethode);
            }
            else{
                var definendMethode = $('input[name=other_method]').val();
                localStorage.setItem('payment_methode', paymentMethode);
            }
            window.location.replace('/orderPlacementInfo/checkOut');
        }
    </script>
@endsection