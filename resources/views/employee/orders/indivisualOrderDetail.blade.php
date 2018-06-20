@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Order Detail</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @include('partials.admin._ordernav')
                    </div>
                    <div class="tab-content">
                        <div id="order_detail" class="tab-pane fade in active">
                            <div class="panel-body">
                                <div>
                                    <h3>Order Info</h3>
                                    <table style="vertical-align: middle;text-align: justify;" class="table table-responsive table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Issue Date</th>
                                            <th>Order Value</th>
                                            <th>Order Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$Order->order_number}}</td>
                                            <td>{{$Order->created_at}}</td>
                                            <td>{{$Order->order_value}} tk</td>
                                            <td>{{$Order->status}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><br>
                                <div>
                                    <h3>Ordered Product Info</h3>
                                    <table style="vertical-align: middle;text-align: justify;" class="table table-responsive table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center">Product Info</th>
                                            <th style="text-align: center;">Product Availability</th>
                                            <th style="text-align: center">Voucher</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Order['order_product'] as $item)
                                            <tr>
                                                <td>
                                                    <div style="display: table-row">
                                                        <div style="display: table-cell;">
                                                            <img src="{{$item->photo}}" style="height: 120px;width: 110px">
                                                        </div>
                                                        <div style="display: table-cell; vertical-align: middle; padding-left: 5px; text-align: left;">
                                                            <div>
                                                                <span style="font-weight: bold">{{$item->title}}</span>
                                                            </div>
                                                            <div>
                                                                <span>Size: </span><span>{{$item->size}}</span>
                                                            </div>
                                                            <div>
                                                                <span>Color: </span><span style="background-color: {{$item->color}}; color: {{$item->color}}">pp</span>
                                                            </div>
                                                            <div>
                                                                <span>Product Id: </span><a href="/employee/indivisualProduct/{{ encrypt($item->product_id) }}">{{$item->product_id}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @if($item->available == 'available')
                                                    <td style="vertical-align: middle;text-align: center;">Available</td>
                                                @else
                                                    <td style="background-color: rgba(255, 69, 0, 0.18);vertical-align: middle;text-align: center;"><p>Shortage</p></td>
                                                @endif
                                                <td>
                                                    <table class="table table-responsive ">
                                                        <thead>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Discount</th>
                                                        <th>Unit Total</th>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <?php $total = 0;?>
                                                            <td>{{$item->quantity}}</td>
                                                            <td>{{$item->unit_price}}</td>
                                                            <td>
                                                                <?php
                                                                if($item->discount){
                                                                    $discount = (intval($item->discount)/100)*intval($item->unit_price)*intval($item->quantity);
                                                                    echo $discount;
                                                                }
                                                                else{
                                                                    $discount=0;
                                                                    echo $discount;
                                                                }
                                                                ?> tk
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $unitTotal = (intval($item->quantity)*intval($item->unit_price))-intval($discount);
                                                                echo $unitTotal;
                                                                ?> tk
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                </td>
                                            </tr>
                                        @endforeach
                                        @if($Order->used_point)
                                            <tr>
                                                <td style="background-color: honeydew; ">
                                                    <span style="font-weight: bold; font-size: 25px;">Point Usage</span>
                                                </td>
                                                <td style="text-align: right; background-color: honeydew; ">
                                                    <span style="font-weight: bold; font-size: 25px;">{{$Order->used_point}} </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: honeydew; ">
                                                    <span style="font-weight: bold; font-size: 25px;">Total</span>
                                                </td>
                                                <td style="text-align: right; background-color: honeydew; ">
                                        <span style="font-weight: bold; font-size: 25px;">
                                            <?php
                                            echo (intval($Order->order_value)-intval($Order->used_point));
                                            ?>
                                            tk</span>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="3" style="background-color: honeydew; ">
                                                    <span class="pull-left" style="font-weight: bold; font-size: 25px;">Total</span>
                                                    <span class="pull-right" style="font-weight: bold; font-size: 25px;">{{$Order->order_value}} tk</span>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div><br>
                                <div>
                                    <h3>Shipping Info</h3>
                                    <table class="table table-responsive table-bordered">
                                        <thead>
                                        <th>Shipping Address</th>
                                        <th>Billing Type</th>
                                        <th>Contact Info</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$Order->address}}</td>
                                            <td>{{$Order->payment_methode}}</td>
                                            <td>
                                                <span>email : </span><span style="font-weight: bold; color: blue">{{$Order->email}}</span><br>
                                                <span>Phone : </span><span style="font-weight: bold; color: blue">{{$Order->phone}}</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="invoice" class="tab-pane fade">
                            @if($Order['invoice_id'])
                                <div class="col-xs-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <span class="pull-right"><button class="btn btn-default" onclick="myFunction()">Print</button></span>
                                        <h3 class="pull-right">{{$Order['invoice_id']}}</h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <address>
                                                <strong>Billed To:</strong><br>
                                                {{$Order['user']->name}}<br>
                                                {{$Order['address']}}<br>
                                                <strong>Division: </strong>{{$Order['division']}}<br>
                                                <strong>City: </strong>{{$Order['city']}}
                                            </address>
                                            <address>
                                                <strong>Order Date:</strong><br>
                                                <?php echo date("jS F Y", strtotime($Order['created_at'])); ?><br><br>
                                            </address>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <address>
                                                <strong>Shipped To:</strong><br>
                                                {{$Order['user']->name}}<br>
                                                {{$Order['address']}}<br>
                                                <strong>Division: </strong>{{$Order['division']}}<br>
                                                <strong>City: </strong>{{$Order['city']}}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <address>
                                                <strong>Company Info:</strong><br>
                                                Name<br>
                                            </address>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <address>
                                                <strong>Payment Method:</strong><br>
                                                {{$Order['payment_methode']}}<br>
                                                {{$Order['email']}}
                                            </address>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><strong>Order summary</strong></h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                        <tr>
                                                            <td><strong>Item</strong></td>
                                                            <td class="text-center"><strong>Unit Price</strong></td>
                                                            <td class="text-center"><strong>Quantity</strong></td>
                                                            <td class="text-center"><strong>Total Discount</strong></td>
                                                            <td class="text-right"><strong>Unit Totals</strong></td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($Order['order_product'] as $item)
                                                            <tr>
                                                                <td>{{$item->title}}</td>
                                                                <td class="text-center">{{$item->unit_price}}</td>
                                                                <td class="text-center">{{$item->quantity}}</td>
                                                                <td class="text-center"><?php
                                                                    if($item->discount){
                                                                        $discount = (intval($item->discount)/100)*intval($item->unit_price)*intval($item->quantity);
                                                                        echo $discount;
                                                                    }
                                                                    else{
                                                                        $discount=0;
                                                                        echo $discount;
                                                                    }
                                                                    ?> tk</td>
                                                                <td class="text-right"><?php
                                                                    $unitTotal = (intval($item->quantity)*intval($item->unit_price))-intval($discount);
                                                                    echo $unitTotal;
                                                                    ?> tk</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                                            <td class="thick-line text-right">{{$Order->order_value}} tk</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="no-line text-center"><strong>Shipping</strong></td>
                                                            <td class="no-line text-right">{{$Order->shipping_cost}} tk</td>
                                                        </tr>
                                                        @if($Order->used_point)
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center"><strong>Point Usage</strong></td>
                                                                <td class="no-line text-right">{{$Order->used_point}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center"><strong>Total</strong></td>
                                                                <td class="no-line text-right"><?php echo (intval($Order->order_value)+intval($Order->shipping_cost)-intval($Order->used_point))?> tk</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center"><strong>Total</strong></td>
                                                                <td class="no-line text-right"><?php echo (intval($Order->order_value)+intval($Order->shipping_cost))?> tk</td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div><button class="btn btn-default" onclick="invoiceCreator('{{$Order['order_id']}}')"> Create Invoice</button></div>
                            @endif
                        </div>
                        <div id="shipping_discussion" class="tab-pane fade">
                            @if($Order['invoice_id'])
                                @if($Order['shipping_id'])
                                    <div class="panel-default">
                                        <div class="panel-heading">Shipping Info</div>
                                        <div class="panel-body">
                                            <p><strong>Order Id: </strong>{{$Order['order_id']}}</p>
                                            <p><strong>Shipping Id: </strong>{{$Order['shipping_id']}}</p>
                                            <p><strong>Tracing Id: </strong>{{$Order['tracking_code']}}</p>
                                            <p><strong>Company name: </strong>{{$Order['company_name']}}</p>
                                            <p><strong>Read File: </strong><a href="/admin/shipping-files/{{$Order['file']}}">File</a></p>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <form id="shipping" action="javascript:shippingCreator('{{$Order['order_id']}}');" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Tracking Id</label>
                                                <input class="form-control" type="text" name="tarcking_id" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input class="form-control" type="text" name="company" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload File</label>
                                                <input class="form-control" id="files" type="file" name="file" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                                            text/plain, application/pdf">
                                                <input type="submit" value="Create">
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @else<h3>Please complete the Previous step(Invoice) and change the order status</h3>
                            @endif

                        </div>
                        <div id="delivery_processing" class="tab-pane fade">
                            <div class="panel-default">
                                <div class="panel-body">
                                    @if($Order['shipping_id'])
                                        <div class="col-sm-12" style="text-align: center"><button class="btn btn-info" id="create-discussion">Create New Discusssion</button></div>
                                        <br>
                                        @if(sizeof($Discussion)>0)
                                            <div class="col-sm-7">
                                                <div class="panel panel-default chat">
                                                    <div class="panel-heading" id="accordion"><svg class="glyph stroked two-messages"><use xlink:href="#stroked-two-messages"></use></svg>Messages</div>
                                                    <div class="panel-body">
                                                        <ul>
                                                            @foreach($Discussion as $item)
                                                                <li class="left clearfix">
                                                            <span class="chat-img pull-left">
                                                                <img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle" />
                                                            </span>
                                                                    <div class="chat-body clearfix">
                                                                        <div class="header">
                                                                            <strong class="primary-font">Admin</strong> <small class="text-muted">{{$item['created_at']}}</small>
                                                                        </div>
                                                                        <p>
                                                                            {{$item['query']}}
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                                <li class="right clearfix">
                                                            <span class="chat-img pull-right">
                                                                <img src="http://placehold.it/80/dde0e6/5f6468" alt="User Avatar" class="img-circle" />
                                                            </span>
                                                                    <div class="chat-body clearfix">
                                                                        <div class="header" style="text-align: right">
                                                                            <strong class="pull-right primary-font">User</strong> <small class="text-muted">{{$item['created_at']}}</small>
                                                                        </div>
                                                                        <p style="text-align: right">
                                                                            {{$item['feedback']}}
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @else <p> No Discussion added yet</p>
                                        @endif
                                        <div id="discussion-container" style="display: none" class="col-sm-5">
                                            <form action="javascript:discussionCreator()" method="post">
                                                <div class="discussion-body">
                                                    <div class="form-group">
                                                        <label>Your Query</label>
                                                        <input class="form-control" type="text" name="query" id="query_1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Customer Feedback</label>
                                                        <textarea class="form-control" name="feedback" id="feedback_1"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-info" type="Submit" value="save">
                                                    <input class="btn btn-info" type="button" value="Add More" id="add-more">
                                                    <input type="hidden" id="discussion-counter" value="1">
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <h3>Pleas Complete Previous step</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="completion" class="tab-pane fade">
                            @if($Order['invoice_id'] && $Order['shipping_id'])
                                @if($Order['status']=='paid')
                                    <div class="panel-default">
                                        <div class="panel-body">
                                            <h3>You order pocessing steps are all completed. This order is paid.</h3>
                                        </div>
                                    </div>
                                @else
                                    <input name="complete-status" type="radio" value="Complete"><label>Complete</label><br>
                                    <input name="complete-status" type="radio" value="Delivered"><label>Delivered</label><br>
                                    <div id="payment-status" style="display: none">
                                        <input name="payment-status" type="radio" value="Paid"><label>Paid</label><br>
                                        <input name="payment-status" type="radio" value="Unpaid"><label>Unpaid</label><br>
                                    </div>
                                    <input name="complete-status" type="radio" value="Cancelled"><label>Cancel</label><br>
                                    <button class="btn btn-success" id="completeStatus">Save Status</button>
                                @endif
                            @else
                                <h3>Please Complete the previous steps</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    
    <script>
        $(document).ready(function () {
            $('#create-discussion').click(function () {
                $('#discussion-container').show();
            });

            $('#add-more').click(function () {
                var counter = parseInt($('#discussion-counter').val())+1;
                $('.discussion-body').first().before('<div class="form-group"><label>Your Query</label><input class="form-control" type="text" name="query" id="query_'+counter+'"> </div> <div class="form-group"> <label>Customer Feedback</label> <textarea class="form-control" name="feedback" id="feedback_'+counter+'"></textarea> </div>');
                $('#discussion-counter').val(counter);
            });

            $("input[name ='complete-status']").change(function () {
                console.log($("input[name ='complete-status']:checked").val());
                if ($("input[name ='complete-status']:checked").val() == 'Delivered'){
                    $('#payment-status').show();
                }
                else $('#payment-status').hide();
            });

            $('#completeStatus').click(function () {
                var id = '{{$Order['order_id']}}';
                if ($("input[name ='complete-status']:checked").val() == 'Delivered'){
                    var status = $("input[name ='payment-status']:checked").val();
                }
                else  var status = $("input[name ='complete-status']:checked").val();
                $.ajax({
                    type:'POST',
                    url:'/admin/changeOrderStatus',
                    data:{_token: "{{ csrf_token() }}", id:id, status:status
                    },
                    success: function( msg ) {
                        location.reload();
                    }
                });
            });
            
        });
        function shippingCreator(id) {
            console.log("got it");
                    var tarcking_id = $("input[name = 'tarcking_id']").val();
                    var company = $("input[name = 'company']").val();
                    var file_data = $('#files').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    form_data.append('_token', $("input[name ='_token']").val());
                    $.ajax({
                        url: "/employee/storeFile",
                        type: "post",
                        data: form_data,
                        cache:false,
                        processData: false,
                        contentType: false,
                        success: function (path) {
                            $.ajax({
                                url:"/employee/changeOrderStatus",
                                type:"post",
                                data:{ _token: "{{ csrf_token() }}", id:id, tracking_code:tarcking_id, company:company, status:"Shipping", file:path},
                                success: function(msg){
                                    location.reload();
                                }

                            });
                            console.log(path);
                        }
                    });

        }
        
        function invoiceCreator(id) {
            $.ajax({
                type:'POST',
                url:'/admin/changeOrderStatus',
                data:{_token: "{{ csrf_token() }}", id:id, status:"Invoice"
                },
                success: function( msg ) {
//                    location.reload();
                    console.log(msg);
                }
            });
        }

        function discussionCreator() {
            var discussion_counter = parseInt($('#discussion-counter').val());
            var discussion = [];
            var id = '{{$Order['order_id']}}';
            for(i=1; i<= discussion_counter; i++){
                var query = $('#query_'+i+'').val();
                var feedback = $('#feedback_'+i+'').val();
                discussion.push({
                    'query':query,
                    'feedback':feedback
                });

                $.ajax({
                    type:'POST',
                    url:'/admin/order/orderDiscussion',
                    data:{_token: "{{ csrf_token() }}", id:id, discussion:discussion, status:'Processing-Delivery'
                    },
                    success: function( msg ) {
                        location.reload();
                    }
                });

                console.log(discussion);
            }
        }
        function myFunction() {
            window.print();
        }

    </script>
@endsection