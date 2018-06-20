@extends('layouts.user.layout')
@section('title')
<title>Reset Password</title>
@endsection

@section('content')
    <div id="content" style="margin-top: 10px;">

        <div class="container">

            <div class="row">

                <div class="col-md-8">
                    <!-- *** CUSTOMER MENU ***
_________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-body">
                            <strong>Hello {{$user->name}}</strong><br>
                            <p>Forgot your password. Reset it here.</p>
                            <form id="register-form" action="/new/reset/password/{{encrypt($user->id)}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="Enter New Password">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation" required>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Change Password" class="btn btn-template-main">
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /.col-md-3 -->

                    <!-- *** CUSTOMER MENU END *** -->
                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="/js/user/validators/passwordMatch.validator.js">
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>

@endsection