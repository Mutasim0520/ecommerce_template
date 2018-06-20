@extends('layouts.layout')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <style>
        .thumb {
            height: 75px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
        }
    </style>
    <link type="text/css" href="/css/admin/bootstrap-tagging.css" rel="stylesheet">
@endsection
@section('header')
   Update Product
@endsection
@section('description')
    Update your intended products and details here
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    @if(Auth::user()->role == 'super')
                        <?php
                        $id = $Product->product_id;
                        $url = "/updateProduct/$id";
                        ?>
                    @else
                        <?php
                        $id = $Product->product_id;
                        $url = "/employee/updateProduct/$id"; ?>
                    @endif
                    <form id="baal" role="form" method="post" action={{$url}} enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Title</label>
                                <input class="form-control" name="title" required value="{{$Product->title}}">
                            </div>
                            <div class="form-group" id="flag">
                                <label>Product Detail</label>
                                <textarea class="form-control ckeditor" id="detail" name="detail"><?php echo ($Product->description);?></textarea>
                            </div>
                            <div class="form-group">
                                <label id="color">Available Color</label> <input type="checkbox" name="has_color" value="0">
                                <div class="cp">
                                    <?php
                                        $color_instance = 0;
                                    $oldColorCounter = 0;
                                    $colorArray = [];
                                    $rgbArray = [];

                                     if(sizeof($Color->color)>0){
                                         $color_instance = 1;
                                        $oldColorCounter = 1;
                                        $colorArray = [];
                                        $rgbArray = [];
                                        $p=0;
                                        foreach ($Color->color as $item){
                                        $oldColor = $item->color;
                                        array_push($colorArray,$oldColor);
                                        array_push($rgbArray,$item->rgb);
                                        if( $oldColorCounter==1){
                                        $firstColor = $item->rgb;
                                    ?>
                                    <div id="cp_1"  class="input-group colorpicker-component" style="width: 469.4px; margin-top: 5px">
                                        <input type="text" value="#00AABB" class="form-control" name="color_{{$oldColorCounter}}" />
                                        <span class="input-group-addon"><i id="rgb_1"></i></span>
                                        <a data-toggle="tooltip" title="Add more color" id="add-color" href="#" style="float:left; padding-bottom: 6px;margin-left: 5px; margin-right: -12px;">
                                            <span><i class="fa fa-plus"></i></span></a>
                                    </div>
                                    <?php
                                    }
                                    $oldColorCounter = $oldColorCounter+1;
                                    }
                                     }
                                     else{
                                         $firstColor = "";?>
                                        <div id="cp_1"  class="input-group colorpicker-component" style="width: 469.4px; margin-top: 5px">
                                            <input type="text" value="#00AABB" class="form-control" name="color_1" />
                                            <span class="input-group-addon"><i id="rgb_1"></i></span>
                                            <a data-toggle="tooltip" title="Add more color" id="add-color" href="#" style="float:left; padding-bottom: 6px;margin-left: 5px; margin-right: -12px;">
                                                <span><i class="fa fa-plus"></i></span></a>
                                        </div>
<?php
                                        }
                                    ?>
                                    <input id="color_count" type="hidden" name="color_counter">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload image</label>
                                <input type="file" id="files" name="file[]" multiple>
                                <output id="list"></output>
                            </div>
                            <div class="form-group">
                                <label>Product Tags</label>
                                <input type="text" class="form-control" name="tag" data-role="tagsinput">
                            </div>
                            <div class="form-group">
                                <label>Upload Responsive image for home page (528*343 px recomended)</label>
                                <input type="file" id="resp" name="resp_img" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input class="form-control" name="price" required value="{{$Product->price}}">
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox"  name="discount_label">Discount
                                </label>
                                <label><input type="hidden" name="discount" class="form-control" value="{{$Product->discout}}"></label>
                            </div>
                            <div class="form-group">
                                <label>Product Code</label>
                                <input class="form-control" name="code" value="{{ $Product->code }}">
                            </div>
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control" name="catagory" required>
                                    <option value="">Select Category</option>
                                    @foreach($Catagory as $item)
                                        <option value="{{$item->id}}">{{$item->catagory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Sub-Category</label>
                                <select class="form-control" name="sub_catagory">
                                    <option value="">Select Sub-Category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Sub-sub-category</label>
                                <select class="form-control" name="item">
                                    <option value="">Select Item</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Avaiable Size</label>
                                <label><input type="checkbox" name="has_size"></label>
                                <input type="hidden" name="size" value="0">
                                <div id="size_container" style ="display:none;">
                                    @foreach($Sizes as $size)
                                        <div class="checkbox">
                                            <div class="col-md-2">
                                                <label>
                                                    <input type="checkbox" value="{{$size->size}}" name="size_{{$size->id}}"><?php echo $size->size;?>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label id="{{$size->size}}"><input name="{{$size->id}}_quantity" class="form-control" style="display: inline-block" type="number" name="quantity" min="1" max="1000"></label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="quantity_container">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" name="quantity" min="1"  required value="{{$Product->quantity}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                        <input type="hidden" id="color_rgb_1" name="color_rgb_1" value="{{$firstColor}}">
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.col-->
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>
    <script src="/js/admin/ckeditor/ckeditor.js"></script>
    <script src="/js/admin/bootstrap-tagging.js"></script>
    <script src="/js/admin/tapered.bundle.js"></script>

    <script>
        $('input[name=has_color]').change(function () {
            if($('input[name=has_color]').is(":checked")){
                $('.cp').show();
                $('input[name=has_color]').val(1);
            }
            else{
                $('.cp').css('display','none');
                $('input[name=has_color]').val(0);
            }
        });

        $('select[name=catagory]').change(function () {
            var catagory = $('select[name=catagory]').val();
            var arr = JSON.parse(JSON.stringify({!! $Sub !!}));
            for(var i=0; i<arr.length; i++){
                if(arr[i].id == catagory){
                    var sub = arr[i].sub;
                    if(sub.length>0){
                        $('select[name=sub_catagory]').html('');
                        $('select[name=sub_catagory]').append($('<option>', {
                            value:'',
                            text:"Select Sub-category"
                        }));
                        $('select[name=item]').html('');
                        $('select[name=item]').append($('<option>', {
                            value:'',
                            text:"Select Item"
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
                            text:"No subcategory under the category"
                        }));
                        $('select[name=item]').html('');
                        $('select[name=item]').append($('<option>', {
                            value:'',
                            text:"Select Item"
                        }));
                    }
                }
            }
        });

        $('select[name=sub_catagory]').change(function () {
            var catagory = $('select[name=sub_catagory]').val();
            console.log(catagory);
            var arr = JSON.parse(JSON.stringify({!! $item_sub !!}));
            console.log(arr);
            for(var i=0; i<arr.length; i++){
                if(arr[i].id == catagory){
                    var sub = arr[i].item;
                    if(sub.length>0){
                        $('select[name=item]').html('');
                        $('select[name=item]').append($('<option>', {
                            value:'',
                            text:"Select Item"
                        }));
                        for(var k = 0;k<sub.length;k++){
                            $('select[name=item]').append($('<option>', {
                                value:sub[k].id,
                                text:sub[k].name
                            }));
                        }
                    }
                    else{
                        $('select[name=item]').html('');
                        $('select[name=item]').append($('<option>', {
                            value:'',
                            text:"No sub-sub-category under the sub-category"
                        }));
                    }
                }
            }

        });
        var has_color = '{{$Product->has_color}}';

        $(document).ready(function() {
            $('.cp').css('display','none');
            if(has_color == '1'){
                $('input[name=has_color]').val(1);
                $('input[name=has_color]').attr('checked','checked');
                $('.cp').show();
            }
            else{
                $('#color_count').val(0);
                $('#cp_1').colorpicker({
                    color: 'rgb(0,0,0)',
                    format: 'rgb',
                    colorSelectors: {
                        'black': '#000000',
                        'white': '#ffffff',
                        'red': '#FF0000',
                        'gray': '#777777',
                        'green': '#5cb85c',
                        'blue': '#5bc0de',
                        'yellow':'#ffff00',
                        'pink':'#ff00ff',
                        'brown':'#cc0000',
                        'orange':'#ff8000'
                    }
                }).on('changeColor', function() {
                    setRGB(this);
                });
            }

            var tags = JSON.constructor({!! $Product->tag !!});
            for(var i = 0; i<tags.length; i++){
                var tag = JSON.constructor({!! $Product->tag !!});
                $('input[name=tag]').tagsinput('add',tags[i].name);
            }
            console.log(tags);

            if(has_color == '1'){
                var a = '{{$firstColor}}';
                $('#cp_1').colorpicker({
                    color: a,
                    format: 'rgb',
                    colorSelectors: {
                        'black': '#000000',
                        'white': '#ffffff',
                        'red': '#FF0000',
                        'gray': '#777777',
                        'green': '#5cb85c',
                        'blue': '#5bc0de',
                        'yellow':'#ffff00',
                        'pink':'#ff00ff',
                        'brown':'#cc0000',
                        'orange':'#ff8000'
                    }
                }).on('changeColor', function() {
                    setRGB(this);
                });
            }
            var has_size = '{{$Product->has_size}}';
            if(has_size == '1'){
                $('input[name=has_size]').attr('checked',true);
                $('#size_container').show();
                $('input[name=quantity]').removeAttr('required');
                $('#quantity_container').css('display','none');
                $('input[name=size]').val(1);
            }
                <?php
                foreach ($Size->size as $item){
                ?>
            var oldSize = "{{$item->size}}";
            console.log(oldSize);
            var oldQuantity ="{{$item->quantity}}";

            <?php
                foreach ($Sizes as $pk){
                    ?>
            if(oldSize == '{{$pk->size}}'){
                console.log('got it');
                $("input[name=size_{{trim($pk->id)}}]").attr('checked','checked');
                $("input[name={{trim($pk->id)}}_quantity]").val(oldQuantity);
            }
                <?php
                }
                ?>
            <?php
            }
            ?>
        $('input[name=has_size]').change(function () {
                if($('input[name=has_size]').is(":checked")){
                    $('#size_container').show();
                    $('input[name=quantity]').removeAttr('required');
                    $('#quantity_container').css('display','none');
                    $('input[name=size]').val(1);
                }

                else{
                    $('#size_container').css('display','none');
                    $('input[name=quantity]').attr('required',true);
                    $('#quantity_container').show();
                    $('input[name=size]').val(0);
                }
            });

            <?php
            foreach ($Sizes as $item){
            ?>
        $("input[name=size_{{trim($item->id)}}]").change(function () {
                if( $("input[name=size_{{trim($item->id)}}]").is(":checked")){
                    console.log('got it');
                    $("input[name={{trim($item->id)}}_quantity]").attr('required',true);
                }
                else {
                    $("input[name={{trim($item->id)}}_quantity]").removeAttr('required');
                    $("input[name={{trim($item->id)}}_quantity]").val('');

                }

                //console.log($("input[name=size_{{trim($item->id)}}:checked]"));
            });

                <?php
                }
                ?>

            var has_discount = '{{$Product->discout}}';
            console.log(has_discount);
            if(has_discount != '0'){
                $('input[name=discount_label]').attr("checked",true);
                $('input[name=discount]').attr('type','text');
                $('input[name=discount]').val(has_discount);

            }
            $('input[name=discount_label]').change(function () {
                if($('input[name=discount_label]').is(":checked")){
                    $('input[name=discount]').attr('type','text');
                    $('input[name=discount]').attr('required',true);
                }
                else{
                    $('input[name=discount]').attr('type','hidden');
                    $('input[name=discount]').removeAttr('required');
                    $('input[name=discount]').val(0);
                }
            });
            $('[data-toggle="tooltip"]').tooltip();

            function colorFunction (color,i) {
                $('#cp_'+i+'').colorpicker({
                    color:color,
                    format: 'rgb',
                    colorSelectors: {
                        'black': '#000000',
                        'white': '#ffffff',
                        'red': '#FF0000',
                        'gray': '#777777',
                        'green': '#5cb85c',
                        'blue': '#5bc0de',
                        'yellow':'#ffff00',
                        'pink':'#ff00ff',
                        'brown':'#cc0000',
                        'orange':'#ff8000'
                    }
                }).on('changeColor', function() {
                    setRGB(this);
                });
            }

            if(has_color == '1'){
                var counter = parseInt("{{$oldColorCounter}}")-1;
                var apple =[];
                var orange = [];
                <?php
                    foreach($colorArray as $item){
                ?>
                        apple.push("{{ $item }}");
                <?php
                    }
                ?>
                <?php
                    foreach($rgbArray as $item){
                ?>
                        orange.push("{{ $item }}");
                <?php
                    }
                ?>

                console.log(apple);
                console.log(orange);
                var pk = 1;
                for(var i=2; i<=counter;i++){
                    $(".cp").append('<div class="input-group colorpicker-component" id="cp_'+i+'" style="width: 468.4px; margin-top: 5px">'+
                        '<input type="text" value="#00AABB" class="form-control" name="color_'+ i +'">'+
                        ' <span class="input-group-addon">'+'<i id="rgb_'+i+'"></i></span>'+'<a data-toggle="tooltip" title="Remove this color" id="remove-color" href="javascript:colorRemover('+i+');" style="float:left; padding-bottom: 6px;margin-left: 5px; margin-right: -12px;"><span><i class="fa fa-minus"></i></span></a>'+
                        '</div>');
                    $('#color_count').val(counter);
                    colorFunction(apple[pk],i);
                    $("#baal").append('<input type="hidden" id="color_rgb_'+i+'" name="color_rgb_'+i+'" value="'+orange[pk]+'">');
                    pk = pk+1;
                }
            }

            var c;

            var oldCatagory ="{{ $Product->catagorie_id }}";
            var oldSub = "{{ $Product->sub_catagorie_id }}";
            var oldItem = "{{ $Product->catagories_item_id }}";

            $('select[name=catagory] option[value='+ oldCatagory+']').attr('selected','selected');
            if(oldCatagory){
                var arr = JSON.parse('{!! $Sub !!}');
                console.log(arr);
                for(var i=0; i<arr.length; i++) {
                    if(arr[i].id == $('select[name=catagory]').val()){
                        var sub = arr[i].sub;
                        if (sub.length > 0) {
                            $('select[name=sub_catagory]').html('');
                            $('select[name=sub_catagory]').append($('<option>', {
                                value: '',
                                text: "Select Sub-catagory"
                            }));
                            $('select[name=item]').html('');
                            $('select[name=item]').append($('<option>', {
                                value: '',
                                text: "Select Item"
                            }));
                            for (var k = 0; k < sub.length; k++) {
                                $('select[name=sub_catagory]').append($('<option>', {
                                    value: sub[k].id,
                                    text: sub[k].name
                                }));
                            }
                        }
                        $('select[name=sub_catagory] option[value='+oldSub+']').attr('selected','selected');
                    }
                }
            }
            if(oldSub){
                var arr = JSON.parse('{!! $item_sub !!}');
                console.log('sub sub item-------------------------------');
                console.log(arr);
                for(var i=0; i<arr.length; i++) {
                    var item = arr[i].item;
                    console.log(item);
                    for(var j = 0;j<item.length;j++){
                        if(item[j].catagorie_id == $('select[name=catagory]').val() && item[j]['sub_catagorie_id'] == $('select[name=sub_catagory]').val()){
                            var sub = item;
                            if(sub.length>0){
                                $('select[name=item]').html('');
                                $('select[name=item]').append($('<option>', {
                                    value:'',
                                    text:"Select Item"
                                }));
                                for(var k = 0;k<sub.length;k++){
                                    $('select[name=item]').append($('<option>', {
                                        value:sub[k].id,
                                        text:sub[k].name
                                    }));
                                }
                            }
                            $('select[name=item] option[value='+oldItem+']').attr('selected','selected');
                            break;
                        }
                    }
                }
            }

            $('#color_count').val(counter);

            $('#add-color').click(function (event) {
                event.preventDefault();
                if($('#color_count').val()){
                    counter = parseInt($('#color_count').val())+1;
                }
                else counter = 2;
                console.log(counter);
                $(".cp").append('<div class="input-group colorpicker-component" id="cp_'+counter+'" style="width: 440.4px; margin-top: 5px">'+
                    '<input type="text" value="#00AABB" class="form-control" name="color_'+counter +'">'+
                    ' <span class="input-group-addon">'+
                    '<i id="rgb_'+counter+'"></i></span>'+'</div>');
                $('#color_count').val(counter);
                $("#baal").append('<input type="hidden" id="color_rgb_'+counter+'" name="color_rgb_'+counter+'" value="rgb(0,0,0)">');

                $(function () {
                    $('#cp_'+counter+'').colorpicker({
                        color: '#000000',
                        format: 'rgb',
                        colorSelectors: {
                            'black': '#000000',
                            'white': '#ffffff',
                            'red': '#FF0000',
                            'gray': '#777777',
                            'green': '#5cb85c',
                            'blue': '#5bc0de',
                            'yellow':'#ffff00',
                            'pink':'#ff00ff',
                            'brown':'#cc0000',
                            'orange':'#ff8000'
                        }
                    }).on('changeColor', function() {
                        setRGB(this);
                    });
                });
            });


            $('.radio').change(function () {
                var type = $('input[name=optionsRadios]:checked').val();
                if (type == "Male"){
                    $('#male-catgory').show();
                    $('#female-catgory').hide();
                }
                else if(type == "Female") {
                    $('#male-catgory').hide();
                    $('#female-catgory').show();
                    $('#kid-catgory').hide();
                }
                else{
                    $('#male-catgory').hide();
                    $('#female-catgory').hide();
                    $('#kid-catgory').show();
                }
            });

            function handleFileSelect(evt) {
                var files = evt.target.files; // FileList object

                // Loop through the FileList and render image files as thumbnails.
                for (var i = 0, f; f = files[i]; i++) {

                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    // Closure to capture the file information.
                    reader.onload = (function(theFile) {
                        return function(e) {
                            // Render thumbnail.
                            var span = document.createElement('span');
                            span.innerHTML = ['<img class="thumb" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>'].join('');
                            document.getElementById('list').insertBefore(span, null);
                        };
                    })(f);

                    // Read in the image file as a data URL.
                    reader.readAsDataURL(f);
                }
            }

            document.getElementById('files').addEventListener('change', handleFileSelect, false);
            console.log($('#color_count').val());
//            $('#detail').val(old_description);
        });

        function colorRemover(index) {
            $('#cp_'+index+'').remove();
            var color_counter =  parseInt($('#color_count').val())-1;
            $('#color_count').val(color_counter);
            $('#color_rgb_'+index).remove();
            console.log($('#color_count').val());
        }

        CKEDITOR.replace( 'detail',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            })
        function setRGB(index) {
            var id = (index.id).split('_')[1];
            console.log(id)
            $("#color_rgb_"+id).val(document.getElementById('rgb_'+id).style.backgroundColor);
        }

    </script>
@endsection