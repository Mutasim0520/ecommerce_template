@extends('layouts.user.layout')
@section('title')
<title>Account Settings</title>
@endsection

@section('content')
    <div class="single">
        <div class="container">
            <div class="col-md-12 user-box">
                <div class="col-md-12">
                    <center>
                        <div class="user-info">
                            <p>{{$User->name}}</p>
                            <p>{{$User->email}}</p>
                            <p>{{$User->mobile}}</p>
                            <p>{{$User->district}}</p>
                        </div>
                    </center>
                </div>
                    <strong>Hello {{$User->name}}</strong><br>
                    <p>Having great time with us? Here you can see your personal information and change those information.</p>

                    <ul class="nav nav-pills nav-stacked">
                        <li>
                            <a href="{{route('user.order')}}"><i class="fa fa-list"></i>My Orders</a>
                        </li>
                        <li>
                            <a class="normal-links" href="javascript:void(0);" data-toggle="modal" data-target="#myModal_change_setting"><i class="fa fa-lock"></i> Change Personal Information</a>
                        </li>
                        <li>
                            <a class="normal-links" href="javascript:void(0);" data-toggle="modal" data-target="#myModal_change_password"><i class="fa fa-lock"></i> Reset Password</a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Log Out
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        </ul>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal_change_setting" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Your Information</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="/update/personalinfo/{{encrypt($User->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="name" class="form-control" placeholder="Your Name" type="text" value="{{$User->name}}" required>
                        </div>
                        <div class="form-group">
                            <input name="email" class="form-control" placeholder="Your email" type="email" value="{{$User->email}}" required>
                        </div>
                        <div class="form-group">
                            <input name="mobile" class="form-control" placeholder="Your Phone Number" type="text" value="{{$User->mobile}}" required>
                        </div>
                        <div class="form-group">
                            <select id="dis" name="district" class="form-control" autocomplete="on">
                                @foreach($Districts as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="address" required>{{$User->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-template-main" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_change_password" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <form id="register-form" method="post" action="/update/password/{{encrypt($User->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input id="password" name="password" class="form-control" placeholder="New Password" type="password" required>
                        </div>
                        <div class="form-group">
                            <input name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re Type Password" type="password" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-template-main" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script type="text/javascript" src="/js/user/validators/passwordMatch.validator.js">
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
    <script>
        $(document).ready(function(){
            var pre_dis = '{{$User->district}}';
            $('#dis option[value='+pre_dis+']').attr('selected','selected');
            console.log(pre_dis);
        });
    </script>
@endsection