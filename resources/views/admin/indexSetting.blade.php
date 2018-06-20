@extends('layouts.layout')
@section('styles')
@endsection

@section('header')
    Index Settings
@endsection
@section('description')
    Visualize your featured items at the user end
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box" >
                <div class="box-header">Index Page Showcase</div>
                <div class="box-body">
                    <p>You can use product showcasing in your featured product page."Showcase Type 2" contains maximum 5 section. To each section you must add a "Heading", a "label", a "parent catagory" ,a "sub-catagory" and a "Photo". </p>
                    <button class="btn btn-primary btn-flat" id="show" onclick="javascript:showShowcase();">View Showcase</button>
                    <button class="btn btn-primary btn-flat" id="hide" style="display: none;" onclick="javascript:hideShowcase();">Hide Showcase</button>
                    <button class="btn btn-primary btn-flat" id="add_new_section">Add New Showcase</button>
                    <button class="btn btn-primary btn-flat" id="add_existing_section">Add Section To Existing Showcase</button>
                    <div class="col-sm-12" id="showcase" style="display: none;">
                        <div class="col-sm-12">
                            <img src="/images/admin/gallery_2.png"  style="width: 100%;max-height: 400px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box" id="new_showcase" style="display: none;" >
                <div class="box-header">
                    <h3 class="box-title">Add New Showcase</h3>
                </div>
                <div class="box-body">
                     <div class="col-sm-12" id="new_section_container">
                        <form id="new-section" method="post" action="/admin/add/showcase" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Showcase Name</label>
                                <input type="text" class="form-control" name="showcase_name" required>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>Section Products Catagory</label>
                                    <select class="form-control" name="catagory" required>
                                        <option value="">Select One</option>
                                        @foreach($Sub as $item)
                                            <option value="{{$item->id}}">{{$item->catagory_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>Section Products Sub-Catagory</label>
                                    <select class="form-control" name="sub_catagory" required>
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Section Heading</label>
                                <input type="text" class="form-control" name="heading" required>
                            </div>
                            <div class="form-group">
                                <label>Section Label</label>
                                <input type="text" class="form-control" name="label" required>
                            </div>
                            <div class="form-group">
                                <label>Section Photo</label>
                                <input type="file" class="form-control" name="photo"  required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-flat btn-primary" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box" id="existing_showcase" style="display: none;" >
                <div class="box-header">
                    <h3 class="box-title">Add To Existing Showcase</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-12" id="new_section_container">
                        <form method="post" action="/admin/add/existing/showcase" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Select Showcase</label>
                                <select class="form-control" name="showcase" required>
                                    <option value="">Select One</option>
                                    @foreach($existing_simple_index as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>Section Products Catagory</label>
                                    <select class="form-control" name="existing_catagory" required>
                                        <option value="">Select One</option>
                                        @foreach($Sub as $item)
                                            <option value="{{$item->id}}">{{$item->catagory_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>Section Products Sub-Catagory</label>
                                    <select class="form-control" name="existing_sub_catagory" required>
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Section Heading</label>
                                <input type="text" class="form-control" name="heading" required>
                            </div>
                            <div class="form-group">
                                <label>Section Label</label>
                                <input type="text" class="form-control" name="label" required>
                            </div>
                            <div class="form-group">
                                <label>Section Photo</label>
                                <input type="file" class="form-control" name="photo"  required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-flat btn-primary" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Current Showcases</h3>
                </div>
                <div class="box-body">
                    @if(sizeof($simple_index)>0)
                        <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th style="text-align: center">S/N</th>
                                <th style="text-align: center">Item</th>
                                <th style="text-align: center">Detail</th>
                                <th style="text-align: center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            @foreach($simple_index as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @foreach($item->simple_belongs as $belongings)
                                            <div class="col-sm-2" style="border-right: 1px solid grey">
                                                <p>Heading:{{$belongings->heading}}</p>
                                                <p>Label:{{$belongings->label}}</p>
                                                <img src="/images/{{$belongings->photo}}" style="height:90px; width:90px;">
                                            </div>
                                        @endforeach
                                    </td>
                                    <td><a href="/admin/showcase/delete/{{encrypt($item->id)}}" class="btn btn-danger btn-flat"data-toggle="confirmation" data-title="Sure you want to delete?" target="_blank">Delete</a></td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                        @else
                        <p>Currently No Available Showcase</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/admin/validations/indexValidator.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });
        });
        function showShowcase(){
            $('#showcase').show();
            $('#show').css('display','none');
            $('#hide').show();
        }
        function hideShowcase(){
            $('#showcase').css('display','none');
            $('#show').show();
            $('#hide').css('display','none');
        }
        $('#add_new_section').click(function () {
            $('#new_showcase').show();
        });

        $('#add_existing_section').click(function () {
            $('#existing_showcase').show();
        });

        $('select[name=catagory]').change(function () {
            var catagory = $('select[name=catagory]').val();
            var arr = JSON.parse('{!! $Sub !!}');
            for(var i=0; i<arr.length; i++){
                if(arr[i].id == catagory){
                    var sub = arr[i].sub;
                    console.log(i);
                    if(sub.length>0){
                        $('select[name=sub_catagory]').html('');
                        $('select[name=sub_catagory]').append($('<option>', {
                            value:'',
                            text:"Select Sub-catagory"
                        }));
                        for(var k = 0;k<sub.length;k++){
                            $('select[name=sub_catagory]').append($('<option>', {
                                value:sub[k].id,
                                text:sub[k].name
                            }));
                        }
                    }
                    else{
                        $('select[name=sub_catagory]').html('');
                        $('select[name=sub_catagory]').append($('<option>', {
                            value:'',
                            text:"No subcatagory under the catagory"
                        }));
                    }
                }
            }
            console.log(arr.length);

        });
        $('select[name=existing_catagory]').change(function () {
            var catagory = $('select[name=existing_catagory]').val();
            var arr = JSON.parse('{!! $Sub !!}');
            for(var i=0; i<arr.length; i++){
                if(arr[i].id == catagory){
                    var sub = arr[i].sub;
                    console.log(i);
                    if(sub.length>0){
                        $('select[name=existing_sub_catagory]').html('');
                        $('select[name=existing_sub_catagory]').append($('<option>', {
                            value:'',
                            text:"Select Sub-catagory"
                        }));
                        for(var k = 0;k<sub.length;k++){
                            $('select[name=existing_sub_catagory]').append($('<option>', {
                                value:sub[k].id,
                                text:sub[k].name
                            }));
                        }
                    }
                    else{
                        $('select[name=existing_sub_catagory]').html('');
                        $('select[name=existing_sub_catagory]').append($('<option>', {
                            value:'',
                            text:"No subcatagory under the catagory"
                        }));
                    }
                }
            }
            console.log(arr.length);

        });
    </script>
@endsection