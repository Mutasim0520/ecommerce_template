<?php
    use App\Catagorie as Catagory;
    $data  = Catagory::with(['sub' => function($query){
        return $query->orderBy('name','ASC');
    },'sub.item' =>function($query){
        return $query->orderBy('name','ASC');
    }])->orderBy('catagory_name','ASC')->get();
?>
@foreach($data as $category)
    @if(sizeof($category->sub)>0)
        <li class="dropdown menu__item">
            <a href="javascript:void(0);" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$category->catagory_name}} <span class="caret"></span></a>
            <ul class="dropdown-menu multi-column columns-3">
                <div class="row">
                    <div class="col-sm-6 multi-gd-img1 multi-gd-text ">
                        <a href="/category/{{$category->catagory_name}}"><img src="/images/category/{{$category->photo}}" alt=" "/></a>
                    </div>
                    @foreach($category->sub as $sub)
                        <div class="col-sm-3 multi-gd-img">
                            <li>
                                <a class="sub-category" href="/subCatagoryWiseProduct/{{$sub->id}}">{{$sub->name}}</a>
                                @if(sizeof($sub->item)>0)
                                    <ul class="multi-column-dropdown">
                                        @foreach($sub->item as $item)
                                            <li><i class="fa fa-angle-right" style="margin-right: 5px;"></i><a href="/item/{{$item->name}}">{{$item->name}}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        </div>
                    @endforeach
                </div>
                <div class="clearfix"></div>
            </ul>
        </li>
    @else
        <li class=" menu__item"><a class="menu__link" href="electronics.html">{{$category->catagory_name}}</a></li>
    @endif
@endforeach