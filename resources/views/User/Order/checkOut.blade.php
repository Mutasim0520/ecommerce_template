@extends('layouts.user.layout')
@section('title')
    <title>Checkout</title>
@endsection
@section('styles')

@endsection
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h4>Checkout confirmation</h4>
        </div>
    </div>
@endsection
@section('content')
    <div class="checkout" style="display: none;">
        <div class="container">
            <div id="wait" class="col-sm-12" style="display: none;">
                <h1><center>Please wait. Your order is under processing.</center></h1>
                <center><div class="loader"></div></center>
            </div>
            <div id="tab-con">
                <div class="col-md-12 table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
                    <table class="timetable_sub">
                        <thead>
                        <th>Product</th>
                        <th>Detail</th>
                        <th>Quantity</th>
                        <th>Unit price</th>
                        <th>Discount</th>
                        <th>Total</th>
                        </thead>
                        <tbody id="item-carts" >
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 2em" class="col-md-6" data-wow-delay=".5s">
                    <div class="checkout-left-basket animated wow slideInLeft" >
                        <h4>Checkout Address</h4>
                        <ul id="checkout_address">
                        </ul>
                    </div>
                </div>
                <div style="margin-top: 2em" class="col-md-6" data-wow-delay=".5s">
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
                <div class="clearfix"></div>
            </div>
            <form style="margin-top: 2em;" action="javascript:callAjax();">
                {{csrf_field()}}
                <div class="pull-left">
                    <input style="margin-right: 10px;" type="checkbox" required><label> I accept all terms and conditions.<a href="javascript:void(0);" data-toggle="modal" data-target="#model_tandc">See Terms & Conditions</a></label>
                </div>
                <div class="pull-right">
                    <button type="submit">Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade success-popup" id="product_out_of_stock" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="lead product_unavailable"></p>
                </div>
                <div class="modal-footer text-center">
                    <a class="btn btn-template-main" href="/cart">Go To Cart</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade success-popup" id="model_tandc" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h3>Terms & Conditions</h3>
                </div>
                <div class="modal-body text-center">
                    <p class="lead product_unavailable">
                        T&C
                    </p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-template-main" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var voucher = JSON.parse(localStorage.getItem('voucher'));
            if(voucher){
                $('.checkout').show();
            }
            else {
                window.location.replace('/cart');
            }
            var address =  voucher[0].address;
            var city =  voucher[0].city;
            var email =  voucher[0].email;
            var phone =  voucher[0].phone;
            $("#checkout_address").append('<li> Address<i>-</i>'+ address +'<span"></span></li>');
            $("#checkout_address").append('<li> City<i>-</i>'+ city +'<span></span></li>');
            $("#checkout_address").append('<li> Email<i>-</i>'+ email +'<span></span></li>');
            $("#checkout_address").append('<li style="border-top: none;"> Phone<i>-</i>'+ phone +'<span></span></li>');

            console.log(voucher);
            function itemAdder() {
                var products = JSON.parse(localStorage.getItem('productId'));
                //console.log(products);
                if(products.length >0){
                    $('#cart_container').show();
                    $('#mes').hide();
                }
                console.log(products);
                var final_total = 0;
                for(var i = 0; i < products.length; i++) {
                    $('#item-carts').append('<tr>'+'<td><img style="height: 50px;width: 56px;" src="'+products[i].photo+'" alt="Image not found"></td><td><h5>'+ products[i].title +'</h5> <small>Size:'+ products[i].sizes +'</small> ,<small>Size:'+ products[i].colors +'</small><br><small>Product Code:'+ products[i].code +'</small></td>'+'<td id="quantity_'+ i +'">'+products[i].quantity+'</td>'+
                        '<td>'+'<p>'+ products[i].price +' tk</p>'+'</td>'+'<td>'+'<p id="total_discount_'+i+'"></p>'+'</td>'+
                        '<td> <p id="total_'+ i +'"></p></td>'+'</tr>');
                    var q = (parseInt($('#quantity_'+ i +'').text()));
                    console.log(q);
                    var discount = parseFloat(products[i].discount);
                    var productDiscount = Math.ceil((discount/100)*(parseFloat(products[i].price)));
                    var total = Math.ceil(q*(parseFloat(products[i].price)-productDiscount));
                    var totalDiscount = Math.ceil((q*(parseFloat(products[i].price)))-total);
                    console.log(totalDiscount);

                    $('#total_'+ i+'').text(total+' tk');
                    $('#total_discount_'+ i+'').text(totalDiscount+' tk');

                    final_total = final_total+parseFloat((($('#total_'+ i+'').text()).replace(/[^0-9\.]+/g,'')));
                }
                var shippingCost = parseFloat({{$shipping_cost}});
                var totalwithshipping =(Math.ceil((final_total+shippingCost)/5))*5;
                $('#final-total').text(final_total+' tk');
                $('#pp').text(final_total+' tk');
                $('#totalWithShipping').text(totalwithshipping+' tk')
            }
            itemAdder();
        });

        function callAjax() {
            console.log(1);
            var paymentMethode =localStorage.getItem('payment_methode');
            var definedMethode = localStorage.getItem('defined_methode');
            var voucher = JSON.parse(localStorage.getItem('voucher'));
            ///check availability
            $.ajax({
                type: 'POST',
                url:'/check/product/checkOut',
                data:{_token: "{{ csrf_token() }}", voucher:voucher,
                },
                success: function( msg ) {
                    console.log(msg);
                    msg = JSON.constructor(msg);
                    var item =  JSON.parse(localStorage.getItem('productId'));
                    var avilability = 1;
                    for(var i = 0;i<msg.length; i++){
                        if(msg[i] == 0){
                            $('.product_unavailable').append('<img src="'+item[i].photo+'") style="height: 100px;width: 100px"><br>'+item[i].title+' has just gone out of stock. Please remove this product from cart and try again.');
                            $('#product_out_of_stock').modal('show');
                            avilability = 0;
                            console.log(msg);
                        }
                    }
                    if(avilability == 1){
                        $('#tab-con').hide();
                        $('#wait').show();
                        $.ajax({
                        type: 'POST',
                        url:'/checkOut',
                        data:{_token: "{{ csrf_token() }}", voucher:voucher, paymentMethode:paymentMethode,definedMethod:definedMethode,
                        },
                        success: function( msg ) {
                        console.log(msg);
                            localStorage.clear();
                            window.location.replace('/userOrderDetail');

                        }
                        });

                    }
                }
            });

        }

    </script>
@endsection