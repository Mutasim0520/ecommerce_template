@extends('layouts.layout')
@section('styles')
    <link href=" https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Employee Management</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-striped table-hover" width="100%" cellspacing="0" id="myTable">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Employee Name</th>
                                <th>Created At</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Employee Name</th>
                                <th>Created At</th>
                                <th>Operations</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($Admins as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a class="btn btn-large btn-primary" href="/admin/employee/update/{{encrypt($item->id)}}">Update</a>
                                        <a class="btn btn-large btn-danger" data-toggle="confirmation" data-title="Sure you want to delete?" href="javascript:deleteEmployee({{$item->id}})" target="_blank">Delete</a>
                                    </td>
                                </tr>
                                <?php $i =$i+1; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });

            $('#myTable').DataTable({
                initComplete: function () {
                    this.api().columns([1,2]).every( function () {
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

        });
        function deleteEmployee(id) {
            $.ajax({
                type:'POST',
                url:'/admin/deleteEmployee',
                data:{_token: "{{ csrf_token() }}",id:id
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
    </script>
@endsection