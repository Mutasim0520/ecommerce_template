@extends('layouts.layout')
@section('styles')
    <link href=" https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">User Management</div>
            <div class="panel-body">
                <button id="Send-Mail" class="btn btn-primary">Send mail To Subscribers</button><br>
                <div id="mailsendContainer" style="display: none;">
                    <form action="{{Route('employee.send.mail.subscriber')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Subject</label>
                            <input class="form-control" name="mail_subject" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea id='mail_body' name="mail_body" class="form-control ckeditor" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">User List</div>
            <div class="panel-body">
                <table class="table table-striped table-hover" width="100%" cellspacing="0" id="myTable">
                    <thead>
                        <tr>
                            <th data-field="id" data-align="center">S/N</th>
                            <th data-field="name" data-align="center">User</th>
                            <th data-field="email" data-align="center">Email</th>
                            <th data-field="Phone" data-align="center">Phone</th>
                            <th data-field="created_at" data-align="center">Registered At</th>
                            <th data-field="subscriber" data-align="center">Subscriber</th>
                            <th data-field="District" data-align="center">District</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th data-field="id" data-align="center">S/N</th>
                        <th data-field="name" data-align="center">User</th>
                        <th data-field="email" data-align="center">Email</th>
                        <th data-field="Phone" data-align="center">Phone</th>
                        <th data-field="created_at" data-align="center">Registered At</th>
                        <th data-field="subscriber" data-align="center">Subscriber</th>
                        <th data-field="District" data-align="center">District</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php $i = 1; ?>
                        @foreach($Users as $item)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->mobile}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    @if($item->subscriber)
                                        Subscriber
                                        @else
                                        No
                                    @endif
                                </td>
                                <td>{{$item->district}}</td>
                            </tr>
                            <?php $i =$i+1; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/admin/data-table.min.js" type="text/javascript"></script>
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script src="/js/admin/ckeditor/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
           $('#Send-Mail').click(function () {
               $('#mailsendContainer').show();
               console.log('hello');
           });
            $('#myTable').DataTable({
                initComplete: function () {
                    this.api().columns([1,2,3,4,5,6]).every( function () {
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
        CKEDITOR.replace( 'mail_body',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            });
    </script>
@endsection