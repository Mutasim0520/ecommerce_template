
@extends('layouts.layout')
@section('header')
    Dashboard
@endsection
@section('description')
@endsection
@section('content')
    <div class="col-sm-12 main">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$newOrder}}</h3>

                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$user}}</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$subscriber}}</h3>

                        <p>Subscribers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Company Profile Management</div>
                    <div class="panel-body">
                        <button id="edit_company_info" class="btn btn-flat btn-primary">Edit Company Profile</button>
                        <div id="company_profile_container" style="display: none;">
                            <form action="/admin/add/company/profile" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input class="form-control" type="text" name="company_name" required value="{{$company_info->company_name}}">
                                </div>
                                <div class="form-group">
                                    <label>Company Address</label>
                                    <input class="form-control" type="text" name="company_address" required value="{{$company_info->company_address}}">
                                </div>
                                <div class="form-group">
                                    <label>Company Email</label>
                                    <input class="form-control" type="email" name="company_email" required value="{{$company_info->company_email}}">
                                </div>
                                <div class="form-group">
                                    <label>Company Contact Number</label>
                                    <input class="form-control" type="text" name="company_contact" required value="{{$company_info->company_contact}}">
                                </div>

                                <div class="form-group">
                                    <label>About Company</label>
                                    <textarea class="form-control" type="text" id="slide_description" name="company_about" required>{{$company_info->company_about}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Logo <img src="/images/logo/{{$company_info->company_logo}}" style="height: 50px;width: 50px"></label>
                                    <input class="form-control" type="file" name="company_logo" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-flat btn-primary" type="submit" value="Save">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading dark-overlay">Order Products</div>
                    <div class="panel-body">
                        <table class="data table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Product ID</th>
                                <th>Number Of Order</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $k = 1; ?>
                            @foreach($OrderedProduct as $item)
                                <tr>
                                    <td>{{$k}}</td>
                                    <td><a href="/indivisualProduct/{{encrypt($item->product_id)}}">{{$item->product_id}}</a></td>
                                    <td>{{$item->count}}</td>
                                </tr>
                                <?php $k++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading dark-overlay">Shipping Cost Management</div>
                    <div class="panel-body">
                        <h4>Current Shipping Cost: {{$company_info->shipping_cost}}</h4>
                        <button class="btn btn-primary" id="dlv_button_add">Edit Shipping Cost</button>
                        <div class="col-sm-12" id="dlv_container" style="display: none;">
                            <form method="post" action="/admin/add/company/profile">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Shipping Cost</label>
                                    <input class="form-control" type="text" name="shipping_cost" value="{{$company_info->shipping_cost}}" required>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-flat btn-primary" type="submit" value="edit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Websites Slide Management</div>
                    <div class="panel-body">
                        <button id="add-slide-button" class="btn btn-flat btn-primary">Add New Slide</button>
                        <div id="slide-container" style="display: none;">
                            <form action="/admin/addSlide" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>Slide Title</label>
                                    <input class="form-control" type="text" name="slide_title" required>
                                </div>
                                <div class="form-group">
                                    <label>Slide Redirection Link</label>
                                    <input class="form-control" type="url" name="slide_link">
                                </div>
                                <div class="form-group">
                                    <label>Slide Description</label>
                                    <textarea class="form-control" type="text" id="slide_description" name="slide_description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload Photo(1140*380 recomended)</label>
                                    <input class="form-control" type="file" name="file" accept="image/*" required>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-flat btn-primary" type="submit" value="Save">
                                </div>
                            </form>
                        </div>
                        @if(sizeof($Slide)>0)
                            <table class="table table-responsive table-hover">
                                <thead>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Redirection Link</th>
                                <th>Operation</th>
                                </thead>
                                <tbody>
                                <?php $k =1; ?>
                                @foreach($Slide as $item)
                                    <tr>
                                        <td style="vertical-align: middle">{{$k}}</td>
                                        <td style="vertical-align: middle">{{$item->title}}</td>
                                        @if($item->description)
                                            <td style="vertical-align: middle"><?php echo $item->description;?></td>
                                        @else<td style="vertical-align: middle" >No Description Given</td>
                                        @endif
                                        <td><img src="/images/user/slides/{{$item->url}}" style="height:80px; width:150px;border: 1px solid black;"></td>
                                        <td>
                                            <?php
                                                if($item->link){
                                                    $link = $item->link;
                                                }
                                                else{
                                                    $link = "javascript:void(0)";
                                                }
                                            ?>
                                            <a target="_blank" href="{{$link}}">
                                                @if($item->link)
                                                    Link
                                                    @else
                                                    No link given
                                                @endif
                                            </a>
                                        </td>
                                        <td style="vertical-align: middle"><a class="btn btn-large btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="/admin/deleteSlide/{{$item->id}}" target="_blank">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $k = $k+1; ?>
                                @endforeach
                                </tbody>
                            </table>

                        @endif


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading dark-overlay">
                        Category Management
                    </div>
                    <div class="panel-body">
                        <div class="col-md-11">
                            <table class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>Categories</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Catagory as $item)
                                    <tr>
                                        <td>
                                            {{$item->catagory_name}}
                                        </td>
                                        <td>
                                            <a class="btn btn-large btn-primary" href="javascript:void(0);" data-toggle="modal" data-target="#update_category_{{$item->id}}"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-large btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="/admin/delete/category/{{$item->id}}" data-target="_blank"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1">
                            <h3>Add New</h3>
                            <a id="item-button" class="btn btn-flat btn-primary" href="javascript:void(0);" data-toggle="modal" data-target="#add_category">Add</a>
                        </div>
                        <div class="col-md-11">
                            <table class="table table-responsive table-bordered data3">
                                <thead>
                                <tr>
                                    <th>Sub-Categories(Parent Category)</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sub_category as $item)
                                    <tr>
                                        <td>
                                            {{$item->name}}({{$item['catagorie']->catagory_name}})
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-primary" href="javascript:void(0);" data-toggle="modal" data-target="#update_sub_category_{{$item->id}}"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="/admin/delete/subcategory/{{$item->id}}" data-target="_blank"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1">
                            <h3>Add New</h3>
                            <a id="item-button" class="btn btn-flat btn-primary" href="javascript:void(0);" data-toggle="modal" data-target="#add_sub_category">Add</a>
                        </div>
                        <div class="col-md-11">
                            <table class="table table-responsive table-bordered data1">
                                <thead>
                                <tr>
                                    <th>Sub-sub-Categories (Parent Sub-Category)(Parent Category)</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $i =0;?>
                                @foreach($sub_sub_category as $item)
                                    <tr>
                                        <td>
                                            {{$item->name}} <strong>({{$item['sub_catagorie']->name}})({{$item['catagorie']->catagory_name}})</strong>
                                        </td>
                                        <td style="">
                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#update_sub_sub_category_{{$item->id}}"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="/admin/delete/sub/subcategory/{{$item->id}}" data-target="_blank"><i class="fa fa-trash"></i></a>

                                        </td>

                                    </tr>
                                    <?php $i++; ?>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1">
                            <h3>Add New</h3>
                            <a id="item-button" class="btn btn-flat btn-primary" href="javascript:void(0);" data-toggle="modal" data-target="#add_sub_sub_category">Add</a>
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
                            @foreach($Avilable_size as $item)
                                <div class="col-md-2">{{$item->size}}</div>
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <div><button id="add-size" class="btn btn-flat btn-primary">Add New Size</button><br></div>
                            <div id="size_container" style="display: none;">
                                <form id="sizeForm" method="POST" action="{{Route('save.size')}}">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input name="size" type="text" placeholder="Enter Size" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="save" class="btn btn-flat btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_sub_sub_category" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new Sub-sub-category</h4>
                </div>
                <div class="modal-body">
                    <form id="catagory_form" method="post" action="{{Route('admin.add.item.catagory')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Sub-sub-category Name</label>
                            <input class="form-control" type="text" name="item_name" required>
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select class="form-control" name="item_catagory" required>
                                <option value=""> Select Catagory</option>
                                @foreach($Sub as $item)
                                    <option value="{{$item->id}}">{{ $item->catagory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Sub-Category</label>
                            <select class="form-control" name="item_sub_catagory" required>
                                <option value=""> Select Sub-Category</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control btn-success" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="add_sub_category" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new Sub-category</h4>
                </div>
                <div class="modal-body">
                    <form id="sub_form" method="post" action="{{Route('admin.add.sub.catagory')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Sub-Category Name</label>
                            <input class="form-control" type="text" name="sub_name" required>
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select class="form-control" name="sub_catagory" required>
                                <option value=""> Select Category</option>
                                @foreach($Catagory as $item)
                                    <option value="{{$item->id}}">{{$item->catagory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control btn-success" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="add_category" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new Category</h4>
                </div>
                <div class="modal-body">
                    <form class="category_form" method="post" enctype="multipart/form-data" action="{{Route('admin.add.catagory')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Category Name</label>
                            <input class="form-control" type="text" name="catagory_name" required>
                        </div>
                        <div class="form-group">
                            <label>Category Photo (min 364.717×473.85 px recomended)</label>
                            <input class="form-control" type="file" name="catagory_photo" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control btn-success" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @foreach($Catagory as $item)
        <div class="modal fade" id="update_category_{{$item->id}}" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Category</h4>
                    </div>
                    <div class="modal-body">
                        <form class="category_form" method="post" enctype="multipart/form-data" action="/admin/update/category/{{$item->id}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Category Name</label>
                                <input class="form-control" type="text" name="catagory_name" value="{{$item->catagory_name}}" required>
                            </div>
                            <div class="form-group">
                                <label>Category Photo (min 364.717×473.85 px recomended)</label> <img style="height:100px;width: 100px" src="/images/category/{{$item->photo}}">
                                <input class="form-control" type="file" name="catagory_photo" accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control btn-success" type="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    @foreach($sub_category as $item)
        <div class="modal fade" id="update_sub_category_{{$item->id}}" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Sub-category</h4>
                    </div>
                    <div class="modal-body">
                        <form id="sub_form" method="post" action="/admin/update/subcategory/{{$item->id}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Sub-Category Name</label>
                                <input class="form-control" type="text" name="sub_name" value="{{$item->name}}" required>
                            </div>
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control" id="update_sub_category_select_{{$item->id}}" name="sub_catagory" required>
                                    <option value=""> Select Category</option>
                                    @foreach($Catagory as $item2)
                                        <option value="{{$item2->id}}">{{$item2->catagory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control btn-success" type="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            var i = '{{$item['Catagorie']->id}}';
            var ind = '{{$item->id}}';
            $('#update_sub_category_select_'+ind+' option[value='+i+']').prop('selected', true);
        </script>
    @endforeach

    @foreach($sub_sub_category as $item)
        <div class="modal fade" id="update_sub_sub_category_{{$item->id}}" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Sub-sub-category</h4>
                    </div>
                    <div class="modal-body">
                        <form id="sub_form" method="post" action="/admin/update/sub/subcategory/{{$item->id}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Sub-sub-category Name</label>
                                <input class="form-control" type="text" name="item_name" value="{{$item->name}}" required>
                            </div>
                            <div class="form-group">
                                <label>Select Category</label>
                                <select onchange="javascript:changeSub('{{$item->id}}');" class="form-control" id="item_catagory_{{$item->id}}" name="item_catagory_{{$item->id}}" required>
                                    <option value=""> Select Catagory</option>
                                    @foreach($Sub as $item2)
                                        <option value="{{$item2->id}}">{{ $item2->catagory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Sub-Category</label>
                                <select class="form-control" id="item_sub_catagory_{{$item->id}}" name="item_sub_catagory_{{$item->id}}" required>
                                    <option value=""> Select Sub-Category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control btn-success" type="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            var cat = '{{$item['catagorie']->id}}';
            var ind = '{{$item->id}}';
            var sub_cat = '{{$item['Sub_catagorie']->id}}';
            $('#item_catagory_'+ind+' option[value='+cat+']').prop('selected', true);
                    @foreach($Catagory as $cats)
                    @if($cats->id == $item['catagorie']->id)
            var arr = JSON.parse('{!! $cats['sub'] !!}');
            if(arr.length>0){
                $('select[name=item_sub_catagory_'+ind+']').html('');
                $('select[name=item_sub_catagory_'+ind+']').append($('<option>', {
                    value:'',
                    text:"Select Sub-catagory"
                }));
                for(var k = 0;k<arr.length;k++){
                    $('select[name=item_sub_catagory_'+ind+']').append($('<option>', {
                        value:arr[k].id,
                        text:arr[k].name
                    }));
                }
            }
            else{
                $('select[name=item_sub_catagory_'+ind+']').html('');
                $('select[name=item_sub_catagory_'+ind+']').append($('<option>', {
                    value:'',
                    text:"No subcatagory under the catagory"
                }));
            }
            @endif
        @endforeach
        $('#item_sub_catagory_'+ind+' option[value='+sub_cat+']').prop('selected', true);

        </script>
    @endforeach


@endsection

@section('scripts')
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script src="/js/admin/validations/sizeValidator.js"></script>
    <script src="/js/admin/validations/costEstimationValidator.js"></script>
    <script src="/js/admin/validations/poundRateValidator.js"></script>
    <script src="/js/admin/validations/catagoryValidator.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>
    <script src="/js/admin/ckeditor/ckeditor.js"></script>
    <script src="/js/admin/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/js/admin/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script>

        function changeSub (ind) {
            var catagory = $('select[name=item_catagory_'+ind+']').val();
            var arr = JSON.parse(JSON.stringify({!! ($Sub) !!}));
            for(var i=0; i<arr.length; i++){
                if(arr[i].id == catagory){
                    var sub = arr[i].sub;
                    console.log(sub);
                    if(sub.length>0){
                        $('select[name=item_sub_catagory_'+ind+']').html('');
                        $('select[name=item_sub_catagory_'+ind+']').append($('<option>', {
                            value:'',
                            text:"Select Sub-catagory"
                        }));
                        for(var k = 0;k<sub.length;k++){
                            $('select[name=item_sub_catagory_'+ind+']').append($('<option>', {
                                value:sub[k].id,
                                text:sub[k].name
                            }));
                        }
                    }
                    else{
                        $('select[name=item_sub_catagory_'+ind+']').html('');
                        $('select[name=item_sub_catagory_'+ind+']').append($('<option>', {
                            value:'',
                            text:"No subcatagory under the catagory"
                        }));
                    }
                }
            }
            console.log(arr.length);
        }
        function showCostEstimationContainer() {
            $('#cost-estimation-container').show();
        }
        $(document).ready(function () {
            $('.data').DataTable();
            $('.data1').DataTable();
            $('.data3').DataTable();
            $('#add-size').click(function () {
                $('#size_container').show();
            });
            $('#edit_company_info').click(function () {
                $('#company_profile_container').show();
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });

            $('#add-slide-button').click(function () {
                $('#slide-container').show();
                console.log('pasis');
            });

        });

        function showCatagoryContainer() {
            $('#catagory-container').show();
            $('#cata-button').hide();
        }
        function showSubContainer() {
            $('#sub-container').show();
            $('#sub-button').hide();
        }
        function showItemContainer() {
            $('#item-container').show();
            $('#item-button').hide();
        }
        $('select[name=item_catagory]').change(function () {
            var catagory = $('select[name=item_catagory]').val();
            var arr = JSON.parse(JSON.stringify({!! ($Sub) !!}));
            for(var i=0; i<arr.length; i++){
                if(arr[i].id == catagory){
                    var sub = arr[i].sub;
                    if(sub.length>0){
                        $('select[name=item_sub_catagory]').html('');
                        $('select[name=item_sub_catagory]').append($('<option>', {
                            value:'',
                            text:"Select Sub-catagory"
                        }));
                        for(var k = 0;k<sub.length;k++){
                            $('select[name=item_sub_catagory]').append($('<option>', {
                                value:sub[k].id,
                                text:sub[k].name
                            }));
                        }
                    }
                    else{
                        $('select[name=item_sub_catagory]').html('');
                        $('select[name=item_sub_catagory]').append($('<option>', {
                            value:'',
                            text:"No subcatagory under the catagory"
                        }));
                    }
                }
            }
            console.log(arr.length);

        });


        $('#gbp_button').click(function () {
            $('#gbp_container').show();
        });
        $('#dlv_button_add').click(function () {
            $('#dlv_container').show();
        });

        $('#shp_button_add').click(function () {
            $('#shp_add_container').show();
        });

        $('#shp_button_change').click(function () {
            $('#shp_change_container').show();
        });

        CKEDITOR.replace( 'slide_description',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            })

    </script>
@endsection