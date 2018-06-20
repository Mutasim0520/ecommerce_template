@extends('layouts.layout')
@section('header')
    Product Detail
@endsection
@section('description')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
                   <div class="col-md-12">
                       @foreach($Photo->photo as $item)
                           <div class="col-sm-4">
                               <img src="/images/{{$item->url}}" alt="image not found" style="width: 100%; height: 100%"/>
                           </div>
                       @endforeach
                   </div>
                    <div class="col-md-12">
                        <div class="p_d">
                            <span style="font-weight: bold">Product Name: </span>
                            <span>{{ $Product->title }}</span>
                        </div>
                        <div class="p_d"><span style="font-weight: bold">Description: </span><?php echo $Product->description; ?></div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>

                                <th>Code</th>
                                <th>Colors</th>
                                <th>Sizes</th>
                                <th>Quantity</th>
                                <th>Weight(KG)</th>
                                <th>Price</th>
                                <th>Discount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    {{ $Product->code }}
                                </td>
                                <td>
                                    @foreach($Color->color as $item)
                                        <span style="background-color: {{ $item->color }}; color: {{ $item->color }}">pp</span>
                                        <span> {{ $item->color }} </span><br>
                                    @endforeach
                                </td>
                                <td>
                                    @if(sizeof($Size->size)>0)
                                        @foreach($Size->size as $item)
                                            <span> {{ $item->size }}  </span><small>({{$item->quantity}})</small><br>
                                        @endforeach
                                    @else No size available
                                    @endif
                                </td>
                                <td>
                                    {{ $Product->quantity }}

                                </td>
                                <td>{{$Product->delivery_cost_id}}</td>
                                <td>
                                    {{ $Product->price }}.00 GBP
                                </td>
                                <td>
                                    {{ $Product->discout }} %
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection