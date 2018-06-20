@extends('layouts.layout')

@section('styles')
    <link href=" https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection
@section('header')
    All Products
@endsection
@section('description')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                    <div class="box-body">
                        <table class="table table-hover" id="myTable">
                            <thead>
                            <tr>
                                <th data-field="id" data-align="center">S/N</th>
                                <th data-field="Number" data-align="center">Product Code</th>
                                <th data-field="name" data-align="center">Product Name</th>
                                <th data-field="quantity" data-align="center">Available Quantity</th>
                                <th data-field="price" data-align="center">Price</th>
                                <th data-field="discount" data-align="center">Current Discount</th>
                                <th>URL</th>
                                <th data-field="" data-align="center">Operations</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th data-field="id" data-align="center">S/N</th>
                                <th data-field="Number" data-align="center">Product Code</th>
                                <th data-field="name" data-align="center">Product Name</th>
                                <th data-field="quantity" data-align="center">Available Quantity</th>
                                <th data-field="price" data-align="center">Price</th>
                                <th data-field="discount" data-align="center">Current Discount</th>
                                <th>URL</th>
                                <th data-field="" data-align="center">Operations</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($Products as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    @if(Auth::user()->role == 'super')
                                        <td>{{ $item->code }}</td>
                                        <td><a href="/indivisualProduct/{{ encrypt($item->product_id) }}">{{ $item->title }}</a></td>
                                        @if(intval($item->quantity)>0)
                                            <td>{{ $item->quantity }}</td>
                                        @elseif(intval($item->quantity)==0) <td>No Product Available</td>
                                        @else<td>Shortage: {{ intval($item->quantity)*-1 }}</td>
                                        @endif
                                        <td>
                                            {{ $item->price }}
                                            @if($item->currency == 'gbp')
                                                 <?php echo "GBP" ; ?>
                                                @else
                                                <?php echo "BDT" ; ?>
                                                @endif
                                        </td>
                                        <td>{{ $item->discout }}%</td>
                                        <td><a target="_blank" href="{{$item->url}}">URL</a></td>
                                        <td>
                                            <a class="btn btn-large btn-primary" href="/updateProduct/{{encrypt($item->product_id)}}">Update</a>
                                            <a class="btn btn-large btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="javascript:deleteProduct({{$item->product_id}})">Delete</a>
                                        </td>
                                    @endif
                                </tr>
                                <?php $i = $i+1; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/admin/data-table.min.js" type="text/javascript"></script>
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                initComplete: function () {
                    this.api().columns([1]).every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            });

            $('input[type = search]').addClass('form-control');
            $('select').addClass('form-control');
            $('#myTable_length').addClass('col-md-6');
            $('#myTable_length').css('border-bottom','1px solid #e9ecf2');
            $('#myTable_filter').addClass('col-md-6');
            $('#myTable_filter').css('border-bottom','1px solid #e9ecf2');
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });
        });

        function deleteProduct(id) {
            $.ajax({
                type:'POST',
                url:'/admin/deleteProduct',
                data:{_token: "{{ csrf_token() }}",id:id
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
    </script>
@endsection