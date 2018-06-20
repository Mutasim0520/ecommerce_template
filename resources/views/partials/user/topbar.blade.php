<header>
    <div id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-4 hidden-xs contact">
                    <div>
                        <form action="{{Route('user.search')}}" method="get">
                            {{csrf_field()}}
                            <span class="search ">
                            <input type="text" placeholder=" search..." required name="search_item">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </span>
                        </form>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="login">
                        <div>
                            <a href="#" data-toggle="modal" data-target="#cost-estimation"><i class="fa fa-calculator"></i>Cost Estimation</a>
                        </div>
                            @if(Auth::guest())
                            <div>
                                <a href="{{Route('user.sharelink')}}"><i class="fa fa-link"></i>Request Item</a>
                            </div>
                                <div><a href="/login">
                                        <i class="fa fa-sign-in"></i>Sign In</a></div>
                                <div><a href="/register">
                                        <i class="fa fa-lock"></i>Sign Up</a></div>
                            @elseif(Auth::user())
                            <div>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#share-link"><i class="fa fa-link"></i>Request Item</a>
                            </div>
                                <div>
                                    <a href="{{route('user.account.settings')}}" ><i class="fa fa-user"></i>{{Auth::user()->name}}<span data-placement="bottom" data-toggle="tooltip" id="user_notification" style="display: none;" class="user-notification"></span></a>
                                </div>

                            <div>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Sign Out
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>

                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-affixed-top" data-spy="affix" data-offset-top="200" style="box-shadow: 0px 2px 3px rgba(1, 178, 210, 0.31)">

        <div class="navbar navbar-default yamm" role="navigation" id="navbar">

            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand home" href="/">
                        <img src="/images/logo_import_ace.png" alt="import ace logo" class="hidden-xs hidden-sm" style="height: 100%;">
                        <img src="/images/logo_import_ace.png" alt="import ace logo" class="visible-xs visible-sm" style="height: 100%;"><span class="sr-only">Homepage</span>
                    </a>
                    <div class="navbar-buttons">
                        <button type="button" class="navbar-toggle btn-template-main" data-toggle="collapse" data-target="#navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="fa fa-align-justify"></i>
                        </button>
                    </div>
                </div>

                <div class="navbar-collapse collapse" id="navigation">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="/">Home</a>
                        </li>
                            <?php
                                use App\Catagorie as Catagory;
                                use App\Catagories_item as Item;
                                use App\Sub_catagorie as Sub;

                                $Catagory = Catagory::with('sub')->get();
                                $Sub = Sub::with('item')->get();
                                $i = 1;
                                $counter = 1;
                            ?>
                            @foreach($Catagory as $catagory)
                                    <li class="dropdown use-yamm yamm-fw">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">{{$catagory->catagory_name}}<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="yamm-content">
                                                    <div class="row">
                                                        @foreach($Sub as $item)
                                                            @if($catagory->id == $item->catagorie_id)
                                                                <div class="col-sm-3">
                                                                    <h5><a href="/subCatagoryWiseProduct/{{$item->id}}">{{$item->name}}</a></h5>
                                                                    <ul>
                                                                        @foreach($item->item as $prd_item)
                                                                            <li><a href="/item/{{$prd_item->name}}">{{$prd_item->name}}</a></li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <!-- /.yamm-content -->
                                            </li>
                                        </ul>
                                    </li>
                            @endforeach

                        <!-- ========== FULL WIDTH MEGAMENU END ================== -->

                        
						<li>
                            
                                    <form action="{{Route('user.search')}}" method="get">
                                        {{csrf_field()}}
                                        <span class="search hidden-md hidden-lg">
                                            <input type="text" placeholder="Search Product" class="hidden-search" required name="search_item">
                                            <button type="submit"><i class="fa fa-search"></i></button>
                                        </span>
                                    </form>
                                </li>
                                <!--  <li class="cart-has-sub">
                                    <a href="{{ url('/cart')}}" class="cart-icon">
                                        <span id="cartNotification" class="cart-item" style="display: none;"></span>
                                        <img src="/images/user/icon/cart-icon.png" alt="">
                                        <img class="hover-cart" src="/images/user/icon/cart-icon-hover.png" alt="">
                                    </a>
                                    <div class="cart-sub">
                                    </div>
                                </li> -->
                           
                       
                    </ul> 
					
                </div>
				<div class="cart-search">
                            <ul>
                                
                                <li class="cart-has-sub right-pad">
                                    <a href="{{ url('/cart')}}" class="cart-icon">
                                        <span id="cartNotification" class="cart-item" style="display: none;"></span>
                                        <img src="/images/user/icon/cart-icon.png" alt="">
                                        <img class="hover-cart" src="/images/user/icon/cart-icon-hover.png" alt="">
                                    </a>
                                    <div class="cart-sub">
                               
                                    </div>
                                </li>
                            </ul>
                        </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cost-estimation" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Login">Cost Estimation</h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:estimateCost();" method="post">
                        <?php
                            use App\Cost_estimation as CS;
                            $cs = CS::all();
                        ?>
                        <div class="form-group">
                            <label>Cost given at site (In GBP)</label>
                            <input type="text" class="form-control" id="price_cost_estimation"  required>
                        </div>
                        <div class="form-group">
                            <label>Select Website</label>
                            <select id="website_cost_estimation" name="website" required class="form-control">
                                <option value="">Select Website</option>
                                @foreach($cs as $item)
                                    <option value="{{$item->id}}">{{$item->website}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <p class="text-center">
                            <input type="submit" class="btn btn-template-main" value="Estimate">
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="share-link" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Login">Request Item</h4>
                </div>
                <div class="modal-body">
                    <form action="{{Route('user.send.link')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Name Of  Product</label>
                            <input type="text" class="form-control" name="name"  required>
                        </div>
                        <div class="form-group">
                            <label>URL To The Product</label>
                            <input type="url" class="form-control" name="url"  required>
                        </div>
                        <div class="form-group">
                            <label>Size Of Product(if applicable)</label>
                            <input type="text" class="form-control" name="size">
                        </div>
                        <div class="form-group">
                            <label>Color Of Product(if applicable)</label>
                            <input type="text" class="form-control" name="color">
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" min="0" max="1000" required name="quantity">
                        </div>
                        <div class="form-group">
                            <label>Your Name</label>
                            <input type="text" class="form-control" required name="user" value="<?php if(Auth::user()){ echo Auth::user()->name;} ?>">
                        </div>
                        <div class="form-group">
                            <label>Your Phone Number</label>
                            <input type="text" class="form-control" name="phone" required value="<?php if(Auth::user()){ echo Auth::user()->mobile;} ?>">
                        </div>
                        <div class="form-group">
                            <label>Your Email</label>
                            <input type="eamil" class="form-control" name="email" value="<?php if(Auth::user()){ echo Auth::user()->email;} ?>">
                        </div>
                        <p class="text-center">
                            <input type="submit" class="btn btn-template-main" value="Send">
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>

</header>