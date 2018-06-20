@extends('layouts.user.layout')
@section('styles')
    <link href="/css/user/pignose.layerslider.css" rel="stylesheet" type="text/css" media="all" />
@endsection
@section('banner')
    <div class="banner-grid">
        <div id="visual">
            <div class="slide-visual">
                <!-- Slide Image Area (1000 x 424) -->
                <ul class="slide-group">
                    @foreach($Slide as $item)
                        <li><img class="img-responsive" src="/images/user/slides/{{$item->url}}" alt="Dummy Image" /></li>
                    @endforeach
                </ul>
                <div class="script-wrap">
                    <ul class="script-group">
                        @foreach($Slide as $item)
                            <li><img class="img-responsive slide-resp" src="/images/user/slides/{{$item->url}}" alt="Dummy Image" /></li>
                        @endforeach
                    </ul>
                    <div class="slide-controller">
                        <a href="#" class="btn-prev"><img src="/images/user/images/btn_prev.png" alt="Prev Slide" /></a>
                        <a href="#" class="btn-play"><img src="/images/user/images/btn_play.png" alt="Start Slide" /></a>
                        <a href="#" class="btn-pause"><img src="/images/user/images/btn_pause.png" alt="Pause Slide" /></a>
                        <a href="#" class="btn-next"><img src="/images/user/images/btn_next.png" alt="Next Slide" /></a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <script type="text/javascript" src="/js/user/pignose.layerslider.js"></script>
        <script type="text/javascript">
            //<![CDATA[
            $(window).load(function() {
                $('#visual').pignoseLayerSlider({
                    play    : '.btn-play',
                    pause   : '.btn-pause',
                    next    : '.btn-next',
                    prev    : '.btn-prev'
                });
            });
            //]]>
        </script>

    </div>
@endsection
@section('content')
    <div class="container">
    @foreach($data as $category)
        @if(sizeof($category->sub)>0)
            <div class="content-bottom">
                <center><h3>{{$category->catagory_name}}</h3></center>
                <div class="col-md-2 products-left">
                    <div class="css-treeview">
                        <h4>{{$category->catagory_name}}</h4>
                        <ul class="tree-list-pad">
                            <?php $submenu_counter = 0; ?>
                            @foreach($category->sub as $sub)
                                @if($submenu_counter<10)
                                        <li>
                                            <a href="/subCatagoryWiseProduct/{{$sub->id}}"><i class="fa fa-angle-right" style="margin-right: 5px;"></i>{{$sub->name}}</a>
                                        </li>
                                    @endif
                                    <?php $submenu_counter++; ?>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="col-md-5 content-rgrid text-center">
                        <div class="content-grid-effect slow-zoom vertical">
                            <div class="img-box"><img src="/images/category/{{$category->photo}}" alt="image" class="img-responsive zoom-img"></div>
                            <div class="info-box">
                                <div class="info-content simpleCart_shelfItem">
                                    <h4>{{$category->catagory_name}}</h4>
                                    <span class="separator"></span>
                                    <a class="item_add hvr-outline-out button2" href="/category/{{$category->catagory_name}}">View All </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 content-lgrid">
                        <?php $counter = 0; ?>
                        @foreach($category->product as $product)
                            @if($counter <4)
                                <div class="col-sm-6 content-img-left text-center">
                                    <div class="content-grid-effect slow-zoom vertical">
                                        <div class="img-box"><img style="max-width:364.683px; max-height:236.9px" src="/images/products/{{$product->resp_photo}}" alt="image" class="img-responsive zoom-img"></div>
                                        <div class="info-box">
                                            <div class="info-content simpleCart_shelfItem">
                                                <h4><a href="/productDetail/{{encrypt($product->product_id)}}">{{$product->title}}</a></h4>
                                                <span class="separator"></span>
                                                <p><span class="item_price">BDT {{$product->price}}</span></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <?php $counter++;?>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
                @endif

        <div class="clearfix"></div><br>
    </div>
    @endforeach
    </div>
@endsection