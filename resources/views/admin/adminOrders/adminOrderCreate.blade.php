@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Create Order</h3>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="product_selection">
                        <form action="javascript:orderSender();" method="post">
                                {{csrf_field()}}
                            <div class="panel panel-default">
                                    <div class="panel-heading">Product Selection</div>
                                    <div class="panel-body">
                                        <div class="form-group col-sm-3">
                                            <select  class="form-control" id="product_code" name="product_code" autocomplete="on" required>
                                                <option value="">Select Product Code</option>
                                                @foreach($Products as $item)
                                                    <option value="{{$item->code}}">{{$item->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <select class="form-control" id="product_quantity" name="product_quantity" autocomplete="on" required>
                                                <option value="">Select Quantity</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <select class="form-control" id="product_color" name="product_color" autocomplete="on" required>
                                                <option value="">Select Color</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <select class="form-control" id="product_size" name="product_size" autocomplete="on" required>
                                                <option value="">Select Size</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Address Info</div>
                                <div class="panel-body">
                                    <div class="form-group col-sm-4">
                                        <select id="user" class="form-control" name="user" required>
                                            <option value="">Select User</option>
                                            @foreach($User as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <input id="email" type="email" name="email" class="form-control" required placeholder="Enter email">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <input id="phone" type="text" name="phone" class="form-control" required placeholder="Enter Conatct Number">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <textarea id="address" name="address" class="form-control" required placeholder="Enter Shipping Address"></textarea>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <select id="division" class="form-control" name="division" autocomplete="on" required>
                                            <option value="">Select Division</option>
                                            <option value="Dhaka">Dhaka</option>
                                            <option value="Sylhet">Sylhet</option>
                                            <option value="Chittagong">Chittagong</option>
                                            <option value="Barisal">Barisal</option>
                                            <option value="Rajshahi">Rajshahi</option>
                                            <option value="Khulna">Khulna</option>
                                            <option value="Rangpur">Rangpur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <select id="city" class="form-control" name="city" autocomplete="on" required>
                                            <option value="">Select City</option>
                                            @foreach($Districts as $item)
                                                <option value="{{$item}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <select id="paymentMethode" class="form-control" name="paymentMethode" autocomplete="on" required>
                                            <option value="">Select Payment Methode</option>
                                                <option value="Cash On Delivery">Cash On Delivery</option>
                                                <option value="Other">Other</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-sm-offset-1 col-sm-10 col-sm-offset-1" style="text-align: center;">
                                <input type="submit" style="width: 50%;text-align: center;" class="btn btn-success" value="Create Order">
                            </div>
                        </form>
                    </div>
                </div>
                    <div class="panel-default" id="address_confirmation">
                        <div class="panel-heading panel-blue">
                            Voucher
                        </div>
                       <div class="panel-body">
                           <table class="table responsive">
                               <thead>
                               <tr>
                                   <th>Product</th>
                                   <th>Quantity</th>
                                   <th>Unit price</th>
                                   <th>Discount</th>
                                   <th>Unit Total</th>
                               </tr>
                               </thead>
                               <tbody>
                               <tr>
                                   <td id="cart_product"></td>
                                   <td id="cart_quantity"></td>
                                   <td id="cart_unitPrice"></td>
                                   <td id="cart_discount"></td>
                                   <td id="cart_unitTotal"></td>
                               </tr>
                               </tbody>
                           </table>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script>
        var Unitprice;
        var UnitTotal;
        var quantity;
        var discount;
        var discountInTK;
        var ProductId;
        var ProductTitle;
        var Order_value;
        $(document).ready(function () {
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });
            var products =[];
            var colors = [];
            var sizes =[];
            <?php
                foreach ($Products as $item){
                     foreach ($item['color'] as $color){
                    ?>
                    colors.push('{{$color->color}}');
                    <?php
                        }
                        if($item->has_size =='1'){
                          foreach ($item['size'] as $size){
                    ?>
                    sizes.push('{{$size->size}}');
                    <?php
                        }
                        }
                    ?>
                    products.push({
                        code:'{{$item->code}}',
                        quantity:'{{$item->quantity}}',
                        color:colors,
                        size:sizes,
                        price:'{{$item->price}}',
                        discount:'{{$item->discout}}',
                        id:'{{$item->product_id}}',
                        title:'{{(string)$item->title}}'
                    });
                    colors = [];
                    sizes = [];
                    <?php
                }
                ?>
                console.log(products);

            $('#product_code').change(function () {
                Selected_product = $('#product_code :selected').val();
              var quantity;
              var s,c;
              for(var i = 0; i<products.length;i++){
                  if(Selected_product == products[i].code){
                      quantity = products[i].quantity;
                      Unitprice = products[i].price;
                      discount = products[i].discount;
                      ProductId = products[i].id;
                      ProductTitle = products[i].title;

                      s = products[i].size;
                      c = products[i].color;
                  }
              }
                $('#product_quantity').empty();
                $('#product_color').empty();
                $('#product_size').empty();
                $('#cart_product').empty();
                $('#cart_unitPrice').empty();
                $('#cart_discount').empty();
                $('#cart_unitPrice').append('<span>'+Unitprice+' tk</span>');
                $('#cart_product').append('<span>'+Selected_product+'</span>');

                $('#product_quantity').append('<option value="">Select Quantity</option>');
                $('#product_color').append('<option value="">Select Color</option>');
                $('#cart_unitTotal').empty();
                $('#cart_quantity').empty();

              for(var i=1; i<=quantity;i++){
                  $('#product_quantity').append('<option value="'+i+'">'+i+'</option>');
              }
              if(s.length>0){
                  $('#product_size').append('<option value="">Select Size</option>');
                  for(var i=0;i<s.length;i++){
                      $('#product_size').append('<option value="'+s[i]+'">'+s[i]+'</option>');
                  }
              }
              else {
                  $('#product_size').append('<option value="0">Size Not Applicable</option>');
              }

                for(var i=0;i<c.length;i++){
                    $('#product_color').append('<option value="'+c[i]+'">'+c[i]+'</option>');
                }
            });

            $('#product_quantity').change(function () {
                quantity = $('#product_quantity :selected').val();
                $('#cart_quantity').empty();
                $('#cart_quantity').append('<span>'+quantity+'</span>');
                discountInTK = parseInt(discount)*parseInt(Unitprice)*parseInt(quantity)/100;
                UnitTotal = (parseInt(Unitprice)*parseInt(quantity))-discountInTK;
                $('#cart_discount').empty();
                $('#cart_discount').append('<span>'+discountInTK+' tk</span>');
                $('#cart_unitTotal').empty();
                $('#cart_unitTotal').append('<span>'+UnitTotal+' tk</span>');

            });
        });

        function orderSender() {
            Order_value = parseInt(UnitTotal)-parseInt(discountInTK);
            $.ajax({
                type:'POST',
                url:'/admin/set/order',
                data:{_token: "{{ csrf_token() }}", order_value:Order_value, user_id:$('#user :selected').val(),
                    address:$('#address').val(), phone:$('#phone').val(), city:$('#city :selected').val(), division:$('#division :selected').val(),
                    email:$('#email').val(), quantity:$('#product_quantity :selected').val(), title:ProductTitle,
                    paymentMethode:$('#paymentMethode :selected').val(), id:ProductId, size:$('#product_size :selected').val(),
                    color:$('#product_color :selected').val(), discount:discountInTK, unit_price:Unitprice,total:UnitTotal
                },
                success: function( msg ) {
//                    location.reload();
                }
            });
        }
    </script>
@endsection