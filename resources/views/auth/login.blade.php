@extends('layouts.user.layout')
@section('title')
<title>LogIn</title>
@endsection
@section('content')
    <div class="single">
        <div class="container">
            <div class="login-grids">
                <div class="login">
                    <div class="login-right">
                        <h3>SIGN IN WITH YOUR ACCOUNT</h3>
                        <div>
                            <div class="social-container">
                                <a href="/login/facebook" class="social"> <i class="fa fa-facebook-square" style="margin-right: 1em"></i>Log in with facebook</a>
                            </div>
                            <div class="social-container">
                                <a href="/register" class="social">SIGN UP</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <form style="margin: 2em 0;" method="POST" action="{{ url('/login') }}">
                            {{csrf_field()}}
                            <div class="sign-in {{ $errors->has('email') ? ' has-error' : '' }}">
                                <h4>Email :</h4>
                                <input type="email" name="email" value="Type here" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Type here';}" required="">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                            <div class="sign-in {{ $errors->has('password') ? ' has-error' : '' }}">
                                <h4>Password :</h4>
                                <input name="password" type="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" required="">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                @endif
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#forgot_password">Forgot password?</a>
                            </div>
                            <div class="single-bottom">
                                <input type="checkbox"  id="brand" name="remember" {{ old('remember') ? 'checked' : ''}}>
                                <label for="brand"><span></span>Remember Me.</label>
                            </div>
                            <div class="sign-in">
                                <input type="submit" value="SIGNIN" >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="modal fade" id="forgot_password" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Login">Change Password</h4>
                </div>
                <div class="modal-body">
                    <p>Please provide the email you registered with. we will sent an password reset link to that email.</p>
                    <form action="{{Route('send.password.reset.link')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input class="form-control" name="email" type="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <button type="submit">Send Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection