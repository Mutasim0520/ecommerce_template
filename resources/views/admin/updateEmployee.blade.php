@extends('layouts.layout')
@section('content')
    <div class="col-lg-12 main">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading dark-overlay">Update Employee Info</div>
                    <div class="panel-body">
                        <form method="post" action="/admin/employee/update/{{encrypt($Admin->id)}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" value="{{$Admin->name}}" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" value="{{$Admin->email}}" name="email" required>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary"  type="submit" value="Update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection