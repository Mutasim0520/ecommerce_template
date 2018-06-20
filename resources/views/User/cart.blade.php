@extends('layouts.user.layout')
<title>Cart</title>
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h3>My Shopping Cart</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="checkout">
        <div class="container">
            <h3 id="lead"></h3>
            <div id="tab-con" style="display: none;">
                <div class="col-md-9 table-responsive checkout-right animated wow slideInUp" data-wow-delay=".5s">
                    <table class="timetable_sub">
                        <thead>
                        <th>Product</th>
                        <th>Detail</th>
                        <th>Quantity</th>
                        <th>Unit price</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Remove</th>
                        </thead>
                        <tbody id="item-carts" >
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="5">Total</th>
                            <th id="ppk" colspan="2"></th>
                        </tr>
                        </tfoot>
                    </table>
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

                <div class="col-md-6 checkout-right-basket animated wow slideInRight" data-wow-delay=".5s">
                    <a href="/"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back To Shopping</a>
                </div>
                <div class="col-md-6 checkout-right-basket animated wow slideInRight" data-wow-delay=".5s">
                    <a style="float:right;" href="/orderPlacementInfo/address">Proceed To Checkout<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            if(localStorage.getItem('productId')){
                if(JSON.parse(localStorage.getItem('productId')).length>0){
                    $('#tab-con').show();
                    $('#lead').append("You have "+JSON.parse(localStorage.getItem('productId')).length+" items in your bag.");
                }
                else $('#lead').append('Your bag is currently empty.');
            }
            else{
                $('#lead').append('Your bag is currently empty.');
            }

            function itemAdder() {
                var products = JSON.parse(localStorage.getItem('productId'));
                if(products.length >0){
                    $('#cart_container').show();
                    $('#mes').hide();
                }
                console.log(products);
                var final_total = 0;
                for(var i = 0; i < products.length; i++) {
                    $('#item-carts').append('<tr>'+'<td><img style="height: 50px;width: 56px;" src="'+products[i].photo+'" alt="Image not found"></td><td><h5>'+ products[i].title +'</h5> <small id="size_'+i+'" style="display:none">Size:'+ products[i].sizes +'</small> ,<small id="color_'+i+'" style="display:none">Color: <small style="background-color: '+products[i].colors+';color: '+products[i].colors+'; height: 5px; width: 5px;">M</small></small><br><small>Product Code:'+ products[i].code +'</small></td>'+'<td style="width: 10%;"><label id="L"><form><input id="quantity_'+ i +'" class="form-control" type="number" name="quantity" value="'+products[i].quantity+'" min="1" max="'+products[i].maxQuantity+'" onchange="totalPriceCounter('+products[i].price +','+i+','+products[i].id+','+ products[i].discount +')"></form></label> </td>'+
                        '<td>'+'<p>'+ products[i].price +' tk</p>'+'</td>'+'<td>'+'<p id="total_discount_'+i+'"></p>'+'</td>'+
                        '<td> <p id="total_'+ i +'"></p></td>'+'<td><a href="javascript:itemRemover('+products[i].id+');"><i class="glyphicon glyphicon-trash"></i></a></td>'+'</tr>');
                    var q =(parseInt($('#quantity_'+ i +'').val()));
                    var discount = parseFloat(products[i].discount);
                    var productDiscount =Math.ceil((discount/100)*(parseFloat(products[i].price)));
                    var total = Math.ceil(q*(parseFloat(products[i].price)-productDiscount));
                    var totalDiscount = Math.ceil((q*(parseFloat(products[i].price)))-total);

                    $('#total_'+ i+'').text(total+' tk');
                    $('#total_discount_'+ i+'').text(totalDiscount+' tk');

                    final_total = final_total+parseFloat((($('#total_'+ i+'').text()).replace(/[^0-9\.]+/g,'')));
                    if(products[i].colors){
                        $('#color_'+i).show();
                    }
                    if(products[i].sizes){
                        $('#size_'+i).show();
                    }
                }
                var shippingCost = parseInt({{$shipping_cost}});
                var totalwithshipping = (Math.ceil((final_total+shippingCost)/5))*5;
                $('#final-total').text(final_total+' tk');
                $('#totalWithShipping').text(totalwithshipping+' tk')
                $('#ppk').text(final_total+' tk');
            }
            itemAdder();
        });
        function totalPriceCounter(price,id,pid,discount) {
            var products = JSON.parse(localStorage.getItem('productId'));
            var unitPrice = parseFloat(price);
            var discount = parseFloat(discount);
            var productDiscount = Math.ceil((discount/100)*unitPrice);
            var counter = parseFloat($('#quantity_'+ parseInt(id) +'').val());
            var total = Math.ceil(counter*(unitPrice-productDiscount));
            var totalPrice = unitPrice*counter;
            var totalDiscount = Math.ceil((counter*unitPrice)-total);

            $('#total_discount_'+ id+'').text(totalDiscount+' tk');
            $('#total_'+ parseInt(id) +'').text(total+' tk');

            var finalTotal = 0;

            for (var i =0; i<products.length;i++){
                var itemTotal = $('#total_'+ i +'').text();
                itemTotal = itemTotal.replace(/[^0-9\.]+/g,'');
                finalTotal = parseInt(itemTotal)+finalTotal;
            }

            var shippingCost = parseInt({{$shipping_cost}});
            var totalwithshipping = (Math.ceil((finalTotal+shippingCost)/5))*5;

            $('#final-total').text(finalTotal+' tk');
            $('#totalWithShipping').text(totalwithshipping+' tk');
            $('#ppk').text(finalTotal+' tk');


            for(var i = 0; i < products.length; i++) {
                if(parseInt(products[i].id) == parseInt(pid)){
                    console.log('dukse');
                    var pid = products[i].id;
                    var title = products[i].title;
                    var price = products[i].price;
                    var colors = products[i].colors;
                    var sizes = products[i].sizes;
                    var photo = products[i].photo;
                    var code = products[i].code;
                    var discount = products[i].discount;
                    var quantity = $('#quantity_'+ parseInt(id) +'').val();
                    products.splice(i,1);
                    products.push({
                        id : pid,
                        code:code,
                        title : title,
                        price: price,
                        shippingCost: shippingCost,
                        discount:discount,
                        colors:colors,
                        sizes:sizes,
                        photo:photo,
                        quantity:quantity,
                    });
                    localStorage.setItem('productId', JSON.stringify(products));
                    console.log(localStorage.getItem('productId'));

                }
            }

        }
        function itemRemover(id) {
            var products = JSON.parse(localStorage.getItem('productId'));
            console.log(products);
            for(var i = 0; i < products.length; i++) {
                if(parseInt(products[i].id) == parseInt(id)){
                    products.splice(i,1);
                    localStorage.setItem('productId',JSON.stringify(products));
                    break;
                }
            }
            location.reload();
        }

    </script>
@endsection