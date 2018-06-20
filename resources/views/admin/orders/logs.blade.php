@extends('layouts.layout')

@section('content')
    <div class="panel-default">
        <div class="panel-heading">Logs</div>
        <div class="panel-body">
            @if(sizeof($Logs)<0) No Log Available
            @else
                <table class="table table-responsive">
                    <thead>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Action By</th>
                        <th>Completed At</th>
                    </thead>
                    <tbody>
                        @foreach($Logs as $item)
                            <tr>
                                <td>{{$item['updated_step']}}</td>
                                <td>{{$item['message']}}</td>
                                <td>{{$item['admin']->name}}</td>
                                <td>{{$item['created_at']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection