@extends('layouts.user.layout')
@section('page-head')
    <div class="page-head">
        <div class="container">
            <h3> Showing Result For {{$search_text}}</h3>
        </div>
    </div>
@endsection
@section('content')
    <div class="men-wear">
        <div class="container">
            <div class="col-md-12 products-right">
                @if(sizeof($Product)>0)
                    @foreach($Product as $item)
                        <div class="col-md-3 product-men no-pad-men">
                            <div class="men-pro-item simpleCart_shelfItem">
                                <div class="men-thumb-item">
                                    <img src="/images/products/{{$item['photo'][0]->url}}" alt="" class="pro-image-front">
                                    <img src="/images/products/{{$item['photo'][0]->url}}" alt="" class="pro-image-back">
                                    <div class="men-cart-pro">
                                        <div class="inner-men-cart-pro">
                                            <a href="/productDetail/{{encrypt($item->product_id)}}" class="link-product-add-cart">Quick View</a>
                                        </div>
                                    </div>
                                    <span class="product-new-top">New</span>

                                </div>
                                <div class="item-info-product ">
                                    <h4><a href="/productDetail/{{encrypt($item->product_id)}}">{{$item->title}}</a></h4>
                                    <div class="info-product-price">
                                        @if($item->discount)
                                            <?php
                                            $old_price = floatval($item->price);
                                            $discount = ceil(floatval($item->discount)*$old_price/100);
                                            $new_price = $old_price - $discount;
                                            ?>
                                            <span class="item_price">BDT {{$new_price}}</span>
                                            <del>BDT {{$old_price}}</del>
                                        @else
                                            <span class="item_price">BDT {{$item->price}}</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5>Sorry we could not found any products</h5>
                    <div class="clearfix"></div>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

@endsection