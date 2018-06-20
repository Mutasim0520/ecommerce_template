@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <h3 class="page-header">Tickets</h3>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(sizeof($Tickets)>0)
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket Number</th>
                                <th>Ticket Subject</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Assigned Employee</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket Number</th>
                                <th>Ticket Subject</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Assigned Employee</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($Tickets as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><a href="#" data-toggle="modal" data-target="#myModal{{$i}}">{{$item->id}}</a></td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item['user']->name}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>{{$item->status}}</td>
                                    @if(sizeof($item['admin'])>0)
                                        <td>
                                            {{$item['admin']->name}}
                                        </td>
                                        @else
                                        <td>
                                            <form action="javascript:employeeAssigner({{$item->id}},{{$i}});">
                                                <div class="form-group">
                                                    <select class="form-control" id="employee{{$i}}" >
                                                        <option value="">Select employee</option>
                                                        @foreach($Employees as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input style="width: 100%;" type="submit" value="Assign" class="btn btn-success">
                                                </div>
                                            </form>
                                        </td>
                                        @endif
                                    <td>
                                        @if($item->status == 'Solved' && $item->feedback =! Null)
                                            <a class="btn btn-large btn-primary" href="javascript:showMailContainer({{$item->id}});">Send Feedback</a>
                                        @elseif ($item->status != 'Solved')
                                            {{--<a class="btn btn-large btn-primary" href="#" data-toggle="modal" data-target="#solveTicketModal{{$i}}">Solved</a>--}}
                                            <a class="btn btn-large btn-primary" href="javascript:ticketStatusChanger({{$item->id}});">Solved</a>
                                        @else
                                            No action required
                                        @endif
                                    </td>
                                </tr>
                                <?php $i = $i+1; ?>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No New Records</p>
                        @endif
                </div>
            </div>
        </div>
        <div class="row" id="mailsendContainer" style="display: none;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Mail to user
                </div>
                <div class="panel-body">
                    <form action="{{Route('employee.send.mail.ticketOwner')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Subject</label>
                                <input class="form-control" name="mail_subject" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea id='mail_body' name="mail_body" class="form-control ckeditor" required></textarea>
                            </div>
                        <input type="hidden" id="ticketId" name="ticketId" value="none">
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Send">
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <?php $k=1; ?>
    @foreach($Tickets as $item)
        <div class="modal fade" id="myModal{{$k}}" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ticket Detail</h4>
                    </div>
                    <div class="modal-body">
                        <label>Title: </label><span>{{$item->title}}</span><br>
                        <label>Detail:</label>
                        <p>{{$item->description}}</p>
                        <label>Issued By: </label><span>{{$item['user']->name}}</span><br>
                        <label>Email: </label><span>{{$item['user']->email}}</span><br>
                        <label>Phone: </label><span>{{$item['user']->mobile}}</span><br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php  $k = $k+1;?>
    @endforeach
@endsection

@section('scripts')
    <script src="/js/admin/bootstrap-confirmation.js"></script>
    <script src="/js/admin/ckeditor/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
        });

        function ticketStatusChanger(id,index) {
            console.log($('#subject'+index+'').val());
            $.ajax({
                type:'POST',
                url:'/employee/changeTicketStaus',
                data:{_token: "{{ csrf_token() }}", id:id , status:'Solved'
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
        function showMailContainer(Index) {
            console.log(Index);
            $('#mailsendContainer').show();
            $('#ticketId').val(Index);
            console.log($('#ticketId').val());
        }
    </script>
@endsection