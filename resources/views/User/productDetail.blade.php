@extends('layouts.user.layout')
@section('title')
    <title>{{ $Product->title }}</title>
@endsection
@section('styles')
    <link rel="stylesheet" href="/css/user/flexslider.css" type="text/css" media="screen" />
    <!-- single -->
    <script src="/js/user/imagezoom.js"></script>
    <script src="/js/user/jquery.flexslider.js"></script>
    <!-- single -->
@endsection
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h3>{{ $Product->title }}</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="single">
        <div class="container">
            <div class="col-md-8 single-right-left animated wow slideInUp animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: slideInUp;">
                <div class="grid images_3_of_2">
                    <div class="flexslider">
                        <!-- FlexSlider -->
                        <script>
                            // Can also be used with $(document).ready()
                            $(window).load(function() {
                                $('.flexslider').flexslider({
                                    animation: "slide",
                                    controlNav: "thumbnails"
                                });
                            });
                        </script>
                        <!-- //FlexSlider-->
                        <ul class="slides">
                            @foreach($Photo->photo as $item)
                                <li data-thumb="/images/products/{{$item->url}}">
                                    <div class="thumb-image"> <img id="photo" src="/images/products/{{$item->url}}" data-imagezoom="true" class="img-responsive"> </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 single-right-left simpleCart_shelfItem animated wow slideInRight animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: slideInRight;">
                <h3>{{ $Product->title }}</h3>
                    @if($Product->discount)
                        <?php
                        $unitPrice =((float)$Product->price);
                        $discount = ((float)$Product->discount*$unitPrice/100);
                        $newPrice = ceil($unitPrice-$discount);
                        ?>
                        <p><span class="item_price">BDT {{$newPrice}} </span> <del>BDT {{ $Product->price }}</del></p>
                    @else
                        <p><span class="item_price">BDT {{ $Product->price }}</span></p>

                    @endif
                    <form action="javascript:cartAdder();">
                        <?php $colorCounter = 0; ?>
                        @if(sizeof($Color->color) > 0 )
                                <div class="color-quality">
                                    <div class="color-quality-right">
                                    <h5>Available Color </h5>
                                    @foreach($Color->color as $item)
                                        <lable class="radio-inline">
                                            <input name="color" value="{{$item->color}}" type="radio" id="color_{{$colorCounter}}" required>
                                            <span style="background-color:{{$item->color}}; color:{{$item->color}} ">oo</span>
                                        </lable>
                                        <?php $colorCounter = $colorCounter+1; ?>
                                    @endforeach
                                    </div>
                                </div>

                        @endif
                        <?php $sizeCounter = 0; ?>
                        @if(sizeof($Size->size) >0 )
                                <div class="color-quality">
                                    <div class="color-quality-right">
                                        <h5>Available Size</h5>
                                        <select name="size"  class="frm-field required sect" id="sel1" required>
                                            <option value="">Select Size</option>
                                            @foreach($Size->size as $item)
                                                @if(intval($item->quantity)>0)
                                                    <option  value="{{$item->size}}">{{$item->size}}</option>
                                                    <?php $sizeCounter = $sizeCounter+1; ?>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        @endif
                        @if(intval($Product->quantity)>0)
                                <div class="occasion-cart">
                                    <button type="submit" class="item_add hvr-outline-out button2" id="addToCart">
                                        Add To Cart
                                    </button>
                                </div>

                        @else
                                <div class="occasional">
                                    <h5>This product is out of stock</h5>
                                </div>
                        @endif
                    </form>
                    <div class="occasional">
                        <h5 id="product_add_message" style="display:none;"> Product has been successfully added </h5>
                    </div>
            </div>
            <div class="clearfix"> </div>

            <div class="bootstrap-tab animated wow slideInUp animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: slideInUp;">
                <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Description</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active bootstrap-tab-text" id="home" aria-labelledby="home-tab">
                            <h5>Product Brief Description</h5>
                            <p><?php echo $Product->description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="/js/user/jquery.zoom.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#mainImage').zoom();
            var color_set = JSON.parse('{!! ($Color->color) !!}');
            console.log(color_set.length);
            if(color_set.length == 1){
                $('#color_0').prop('checked',true);
            }
        });
        function cartAdder() {
            var productIds = [];
            var id = "{{ $Product->product_id }}";
            var price = "{{ ceil((floatval($Product->price))) }}";
            var discount = "{{$Product->discount}}";
            var title = "{{ $Product->title }}";
            var code = "{{$Product->code}}";
            var colors="";
            var colorCounter = parseInt("{{ $colorCounter }}");
            if(colorCounter>0){
                colors = $('input[name=color]:checked').val();
            }

            var sizeCounter = parseInt("{{ $sizeCounter }}");
            if(sizeCounter>0){
                var sizes = $('#sel1 :selected').val();
            }
            else sizes="Not Applicable"
            var has_size = '{{$Product->has_size}}';
            var max_quantity = 0;
            var quantity_array =  JSON.constructor({!!  json_encode($Quantity_array)  !!});
            if(has_size=='1'){
                for(var i = 0; i<quantity_array.length; i++){
                   if(quantity_array[i]['size'] ==sizes ){
                       if(parseInt(quantity_array[i]['quantity'])>0) max_quantity = quantity_array[i]['quantity'];
                       else max_quantity = 1;
                   }
                }
            }
            else{
                if(parseInt('{{ $Product->quantity }}')>0) max_quantity = '{{ $Product->quantity }}';
                else max_quantity = 1;
            }
            var photo = $('#photo').attr('src');
            if(localStorage.getItem('productId')){
                var pid = localStorage.getItem('productId');
                var productIds = JSON.parse(pid);
                productIds.push({
                    id : id,
                    code:code,
                    title : title,
                    price: price,
                    discount:discount,
                    colors:colors,
                    sizes:sizes,
                    photo:photo,
                    quantity:'1',
                    maxQuantity:max_quantity,
                });
                localStorage.setItem('productId', JSON.stringify(productIds));
                var notification = productIds.length;
                $('#cartNotification').text(notification);
                console.log(productIds);
            }
            else{
                //console.log(id);
                productIds.push({
                    id : id,
                    code:code,
                    title : title,
                    price: price,
                    discount:discount,
                    colors:colors,
                    sizes:sizes,
                    photo:photo,
                    quantity:'1',
                    maxQuantity:max_quantity,
                });
                localStorage.setItem('productId', JSON.stringify(productIds));
                var notification = productIds.length;
                $('#cartNotification').text(notification);
                console.log(productIds);
            }
            if(localStorage.getItem('productId')){
                if(JSON.parse(localStorage.getItem('productId')).length>0){
                    $('#simpleCart_quantity').text(JSON.parse(localStorage.getItem('productId')).length+" items in your cart.");
                }

            }

            $('#product_add_message').show();

        };

        function wishAdder(productId){
            console.log(productId);
            $.ajax({
                type:'POST',
                url:'/addToWishlist',
                data:{_token: "{{ csrf_token() }}", id:productId
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
    </script>

@endsection