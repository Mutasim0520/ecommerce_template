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
    Add Product
@endsection
@section('description')
    Add your intended products and details here
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    @if(Auth::user()->role == 'super')
                        <?php $url = '/storeProduct'; ?>
                    @else
                        <?php $url = '/employee/storeProduct'; ?>
                    @endif
                    <form id="baal" role="form" method="post" action={{ $url }} enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Title</label>
                                <input class="form-control" name="title" required>
                            </div>
                            <div class="form-group">
                                <label>Product Detail</label>
                                <textarea class="form-control ckeditor" id="detail" name="detail"></textarea>
                            </div>
                            <div class="form-group">
                                <label id="color">Available Color</label> <input type="checkbox" name="has_color" value="0">
                                <div class="pl" style="display: none">
                                    <div  class="input-group colorpicker-component cp" id="color_1">
                                        <input type="text" value="#00AABB" class="form-control" name="color_1" />
                                        <span class="input-group-addon"><i id="rgb_1" onchange="setRGB(1)"></i></span>
                                        <a data-toggle="tooltip" title="More color" id="add-color" href="#" style="float:left; padding-bottom: 6px;margin-left: 5px; margin-right: -12px;"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>

                                <input id="color_count" type="hidden" name="color_counter">
                            </div>
                            <div class="form-group">
                                <label>Upload image</label>
                                <input type="file" id="files" name="file[]" multiple accept="image/*">
                                <output id="list"></output>
                            </div>
                            <div class="form-group">
                                <label>Product Tags</label>
                                <input type="text" class="form-control" name="tag" data-role="tagsinput">
                            </div>
                            <div class="form-group">
                                <label>Upload Responsive image for home page (528*343 px recomended)</label>
                                <input type="file" id="resp" name="resp_img" accept="image/*" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input class="form-control" name="price" required>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox"  name="discount_label">Discount (In Percentage)
                                    <input type="hidden" name="discount" class="form-control" value="0"></label>
                            </div>
                            <div class="form-group">
                                <label>Product Code</label>
                                <input class="form-control" name="code">
                            </div>
                            <div class="form-group">
                                <label>Select Catagory</label>
                                <select class="form-control" name="catagory" required>
                                    <option value="">Select Catagory</option>
                                    @foreach($Catagory as $item)
                                        <option value="{{$item->id}}">{{$item->catagory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Sub-Catagory</label>
                                <select class="form-control" name="sub_catagory">
                                    <option value="">Select Sub-Catagory</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Sub-sub category</label>
                                <select class="form-control" name="item">
                                    <option value="">Select Sub-sub category</option>
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
                                    <input type="text" class="form-control" name="quantity" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                        <input type="hidden" id="color_rgb_1" name="color_rgb_1" value="rgb(0,0,0)">
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
                $('.pl').show();
                $('input[name=has_color]').val(1);
            }
            else{
                $('.pl').css('display','none');
                $('input[name=has_color]').val(0);
            }
        });
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
        $('input[name=discount_label]').change(function () {
            if($('input[name=discount_label]').is(":checked")){
                $('input[name=discount]').attr('type','text');
                $('input[name=discount]').attr('required',true);
            }
            else{
                $('input[name=discount]').attr('type','hidden');
                $('input[name=discount]').removeAttr('required');
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
        });

        <?php
            }
        ?>

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
                            text:"Select Sub-catagory"
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
                            text:"No subcatagory under the catagory"
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
                            text:"No item under the sub-catagory"
                        }));
                    }
                }
            }

        });

        $(document).ready(function() {

            $(function () {
                $('#color_1').colorpicker({
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
            });
            var counter = 1;
            var c;
            $('#color_count').val(counter);
            $('#add-color').click(function (event) {
                event.preventDefault();
                counter = counter+1;
                console.log(counter);
                $(".pl").append('<div class="input-group colorpicker-component cp" id="color_'+ counter +'" style=" width: 469.4px; margin-top: 5px">'+
                    '<input type="text" value="#00AABB" class="form-control" name="color_'+counter +'">'+
                    ' <span class="input-group-addon">'+
                    '<i id="rgb_'+counter+'" onchange="setRGB('+counter+')"></i></span>'+'</div>');
                $("#baal").append('<input type="hidden" id="color_rgb_'+counter+'" name="color_rgb_'+counter+'" value="rgb(0,0,0)">');

                    $('#color_count').val(counter);
                $(function () {
                    $('#color_'+counter+'').colorpicker({
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
                    $('[data-toggle="tooltip"]').tooltip();
                });
            });

            $('#remove-color').click(function (event) {
                event.preventDefault();
                console.log(counter);
                $('#color_'+ counter +'').remove();
                counter = counter-1;
                $('#color_count').val(counter);
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
        });
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
        $('.colorpicker-selectors').css('display','block');
    </script>
@endsection