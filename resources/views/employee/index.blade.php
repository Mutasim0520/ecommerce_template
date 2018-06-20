@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Dashboard</h3>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-blue panel-widget ">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$newOrder}}</div>
                            <div class="text-muted">New Orders</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-red panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$newUser}}</div>
                            <div class="text-muted">New Users</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-teal panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$user}}</div>
                            <div class="text-muted">Total Users</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-orange panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <svg class="glyph stroked wireless router"><use xlink:href="#stroked-wireless-router"/></svg>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$subscriber}}</div>
                            <div class="text-muted">Subscriber</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading dark-overlay">
                            Catagory Management
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9" style="border-right:2px gray; ">
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Male Catagory</p>
                                    <ul>
                                        @foreach($Catagory as $item)
                                            @if($item->catagory_type == 'Male')
                                                <li>
                                                    <td>{{$item->catagory_name}}</td>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Female Catagory</p>
                                    <ul>
                                        @foreach($Catagory as $item)
                                            @if($item->catagory_type == 'Female')
                                                <li>
                                                    <td>{{$item->catagory_name}}</td>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-weight: bold;">Kids Catagory</p>
                                    <ul>
                                        @foreach($Catagory as $item)
                                            @if($item->catagory_type == 'Kids')
                                                <li>
                                                    <td>{{$item->catagory_name}}</td>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a id="cata-button" class="btn btn-default" href="javascript:showCatagoryContainer();">Add New Catagory</a>
                                <div id="catagory-container" style="display: none">
                                    <form method="post" action="{{Route('employee.add.catagory')}}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>Select Type</label><br>
                                            <input type="radio" name="catagory_type" value="Male" required><label>Male</label>
                                            <input type="radio" name="catagory_type" value="Female"><label>Female</label>
                                            <input type="radio" name="catagory_type" value="Kids"><label>Kids</label>
                                        </div>
                                        <div class="form-group">
                                            <label>Catagory Name</label>
                                            <input class="form-control" type="text" name="catagory_name" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control btn-success" type="submit" value="Save">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading dark-overlay">Size Management</div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <h4>All Sizes</h4>
                                <ul>
                                    @foreach($Avilable_size as $item)
                                        <li>{{$item->size}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div><button id="add-size" class="btn btn-default">Add New Size</button><br></div>
                                <div id="size_container" style="display: none;">
                                    <form method="POST" action="{{Route('save.size')}}">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <input name="size" type="text" placeholder="Enter Size" required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="save" class="btn btn-success">
                                        </div>
                                    </form>
                                </div>
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
        $(document).ready(function () {
            $('#add-size').click(function () {
                $('#size_container').show();
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });

            $('#add-slide-button').click(function () {
                $('#slide-container').show();
            });

            var Switch = '{{$point[0]->status}}';
            $('input[name=point-switch][value = '+Switch+']').attr('checked',true);
            if(Switch == '1'){
                $('#last_dis').show();
            }

            $('input[name=point-switch]').change(function () {
                $('#point-button').show();
                console.log($('input[name=point-switch]:checked').val());
                if($('input[name=point-switch]:checked').val()=="1"){
                    $('input[name=point-discount]').attr('type','text');
                    $('input[name=point-discount]').attr('required',true);
                }
                else if($('input[name=point-switch]:checked').val()=="0") {
                    $('input[name=point-discount]').attr('type','hidden');
                    $('input[name=point-discount]').attr('required',false);
                    console.log(1);
                }
            });
        });
        function pointChanger() {
            var status = $('input[name=point-switch]:checked').val();
            var id = '{{$point[0]->id}}';
            if(status == '1'){
                var point_discount = $('input[name=point-discount]').val();
            }
            else var point_discount = 0;

            $.ajax({
                type:'POST',
                url:'/admin/changePointDiscount',
                data:{_token: "{{ csrf_token() }}", status:status, point_discount:point_discount, id:id
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
        function showCatagoryContainer() {
            $('#catagory-container').show();
            $('#cata-button').hide();
        }
    </script>
@endsection