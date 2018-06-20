@extends('layouts.layout')

@section('styles')
    <link href="/css/admin/data-table.css" rel="stylesheet">
    <link href="/css/admin/bootstrap-tagging.css" rel="stylesheet">
@endsection

@section('content')
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Orders</div>
        <div class="panel-body">
            @if(sizeof($Orders)>0)
                <table class="table table-hover" id="myTable">
                    <thead>
                    <tr>
                        <td><input id="searchInput" type="text" class="form-control" placeholder="Serch Your key"></td>
                    </tr>
                    <tr>
                        <th>S/N</th>
                        <th>Number</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Regeion</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Value</th>
                        <th>Log</th>
                    </tr>
                    </thead>
                    <tbody id="fbody">
                    <?php $i = 0;?>
                    @foreach($Orders as $item)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td><a href="/employee/indivisualOrderDetail/{{encrypt($item['order_id'])}}">#{{$item['order_number']}}</a></td>
                            <td><span style="font-weight: bold">{{ substr($item['created_at'], 0, strpos($item['created_at'], ' '))}}</span></td>
                            <td>Customer</td>
                            <td>Dhaka</td>
                            <td>
                                @if(sizeof($item['admin'])>0)
                                    @foreach($item['admin'] as $item2)
                                        <a>{{$item2['name']}}</a>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{$item['status']}}</td>
                            <td>{{$item->order_value}} tk</td>
                            <td><a href="/employee/showLog/{{encrypt($item['order_id'])}}">Log</a></td>
                            {{--<td style="text-align: right"><a href="/admin/indivisualOrderDetail/{{encrypt($item['order_id'])}}">Detail</a></td>--}}
                        </tr>
                        <?php $i = $i+1;?>
                    @endforeach
                    </tbody>
                </table>
                @else
                <p>You are currently not assigned to any order</p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/admin/data-table.min.js" type="text/javascript"></script>
    <script src="/js/admin/bootstrap-tagging.js" type="text/javascript"></script>
    <script src="/js/admin/tapered.bundle.js" type="text/javascript"></script>
    {{--<script src="/js/admin/bootstrap-table.js"></script>--}}
    <script>
        $(document).ready(function () {
            var old_assigned_employee = [];
            @foreach($Orders as $item)
              old_assigned_employee.push("{{$item['assigned_to']}}");
              console.log("got");
            @endforeach
         console.log(old_assigned_employee);

         ////tags input
            $("#searchInput").keyup(function () {
                //split the current value of searchInput
                var data = this.value.split(" ");
                //create a jquery object of the rows
                var jo = $("#fbody").find("tr");
                if (this.value == "") {
                    jo.show();
                    return;
                }
                //hide all the rows
                jo.hide();

                //Recusively filter the jquery object to get results.
                jo.filter(function (i, v) {
                    var $t = $(this);
                    for (var d = 0; d < data.length; ++d) {
                        if ($t.is(":contains('" + data[d] + "')")) {
                            return true;
                        }
                    }
                    return false;
                })
                //show the rows that match.
                    .show();
            }).focus(function () {
                this.value = "";
                $(this).css({
                    "color": "black"
                });
                $(this).unbind('focus');
            }).css({
                "color": "#C0C0C0"
            });
        });

        function employeeAssigner(id,index) {
            console.log(id);
            var employees = $('#assigned_employee'+index+'').val().split(',');
            $.ajax({
                type:'POST',
                url:'/admin/assignEmployee',
                data:{_token: "{{ csrf_token() }}", id:id, employees:employees
                },
                success: function( msg ) {
                    console.log(msg);
                    location.reload();
                }
            });
        }
    </script>
@endsection