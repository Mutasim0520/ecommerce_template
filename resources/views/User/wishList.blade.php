@extends('layouts.user.layout')
<title>Wish List</title>
@section('navigation')
    <div class="mainmenu pull-left">
        <ul class="nav navbar-nav collapse navbar-collapse">
            <li class="dropdown"><a href="#">Men's Wear<i class="fa fa-angle-down"></i></a>
                <ul role="menu" class="sub-menu">
                    @foreach($Catagory as $item)
                        @if($item->catagory_type == 'Male')
                            <li><a href="/user/catagoryProduct/{{$item->catagory_name}}">{{$item->catagory_name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="dropdown"><a href="#">Women's Wear<i class="fa fa-angle-down"></i></a>
                <ul role="menu" class="sub-menu">
                    @foreach($Catagory as $item)
                        @if($item->catagory_type == 'Female')
                            <li><a href="/user/catagoryProduct/{{$item->catagory_name}}">{{$item->catagory_name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="dropdown"><a href="#">Kid's Wear<i class="fa fa-angle-down"></i></a>
                <ul role="menu" class="sub-menu">
                    @foreach($Catagory as $item)
                        @if($item->catagory_type == 'Kids')
                            <li><a href="/user/catagoryProduct/{{$item->catagory_name}}">{{$item->catagory_name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
@endsection
@section('content')
    <section id="cart_items" style="margin-top: 25px;">
        @if(sizeof($WishList)>0)
            <div class="container">
                <div class="table-responsive cart_info table-bordered">
                    <table class="table table-condensed tc">
                        <thead>
                        <tr class="cart_menu">
                            <td class="">Product</td>
                            <td class="">Availability</td>
                            <td class="">Price</td>
                            <td class="">Delete</td>
                            <td class=""></td>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($WishList as $item)
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img src="/images/{{$item->url}}" style="height: 110px; width: 110px;" alt="Image not found"></a>
                                    <h4>{{$item->title}}</h4>
                                    <p>Product Code: {{$item->code}}</p>
                                </td>
                                <td class="">
                                    @if(intval($item->quantity)>0)
                                        <p>In Stock</p>
                                    @else
                                        <p>Out of Stock</p>
                                    @endif
                                </td>
                                <td class="">
                                    <p>{{$item->price}} tk</p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete"href="javascript:wishRemover('{{ encrypt($item->product_id) }}','{{encrypt($item->user_id)}}');"><i class="fa fa-times"></i></a>
                                </td>
                                <td class="">
                                    <a style="color: black" href="/productDetail/{{ encrypt($item->product_id) }}" type="submit" class=" button-2 buttontt checkout-button">
                                        <span>Shop Now</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div id="mes" class="container prd_con" style="padding: 20px;">
                <h4 style=" text-align:center; color: orange;">You have not added any item to your wishlist yet</h4>
            </div>
        @endif
    </section>
{{--<div class="panel-default">--}}
{{--<div class="panel-heading">Wishes</div>--}}
{{--<div class="panel-body">--}}
{{--@foreach($WishList as $item)--}}
        {{--<div style="display: table-row">--}}
            {{--<div style="display: table-cell"><img src="/images/{{$item->url}}" style="height: 100px; width: 80px;"></div>--}}
            {{--<div style="display: table-cell; vertical-align: middle">--}}
                {{--<div><a href="/productDetail/{{ encrypt($item->product_id) }}">{{$item->title}}</a></div>--}}
                {{--<div><a href="javascript:wishRemover('{{ encrypt($item->product_id) }}','{{encrypt($item->user_id)}}');">Remove</a></div>--}}
            {{--</div>--}}
        {{--</div>--}}
{{--@endforeach--}}
{{--</div>--}}
{{--</div>--}}

@endsection
@section('scripts')
<script>
function wishRemover(pid,uid) {
$.ajax({
type:'post',
url:'/removeWish',
data:{_token: "{{ csrf_token() }}", pid:pid, uid:uid
},
success: function() {
    location.reload();
}
});
}
</script>
@endsection
