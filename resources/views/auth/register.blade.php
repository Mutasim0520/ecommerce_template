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
                        <h3>CREATE YOUR ACCOUNT</h3>
                        <div>
                            <div class="social-container">
                                <a href="/login/facebook" class="social"> <i class="fa fa-facebook-square" style="margin-right: 1em"></i>Log in with facebook</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <form style="margin: 2em 0;" method="POST" action="{{ url('/register') }}">
                            {{csrf_field()}}
                            <div class="sign-in {{ $errors->has('name') ? ' has-error' : '' }}">
                                <input id="name" type="text" name="name" required placeholder="Enter Your Name">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="sign-in {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" name="email" placeholder="Enter your email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Type here';}" required="">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                            <div class="sign-in {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" name="password" required placeholder="Enter Your Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="sign-in">
                                <input type="password" placeholder="Confirm Password" name="password_confirmation" required>
                            </div>
                            <div class="sign-in">
                                <input id="name" type="text" id="mobile" name="mobile" required placeholder="Enter Your Contact Number" autofocus>
                            </div>
                            <div class="sign-in"><select id="district" type="text" name="district" required autocomplete="on">
                                    <option value="">Select District</option>
                                    <option value="BARGUNA">BARGUNA</option>
                                    <option value="BARISAL">BARISAL</option>
                                    <option value="BHOLA">BHOLA</option>
                                    <option value="JHALOKATI">JHALOKATI</option>
                                    <option value="PATUAKHALI">PATUAKHALI</option>
                                    <option value="PIROJPUR">PIROJPUR</option>
                                    <option value="BANDARBAN">BANDARBAN</option>
                                    <option value="BRAHMANBARIA">BRAHMANBARIA</option>
                                    <option value="CHANDPUR">CHANDPUR</option>
                                    <option value="CHITTAGONG">CHITTAGONG</option>
                                    <option value="COMILLA">COMILLA</option>
                                    <option value="COX&#039;S BAZAR">COX&#039;S BAZAR</option>
                                    <option value="FENI">FENI</option>
                                    <option value="KHAGRACHHARI">KHAGRACHHARI</option>
                                    <option value="LAKSHMIPUR">LAKSHMIPUR</option>
                                    <option value="NOAKHALI">NOAKHALI</option>
                                    <option value="RANGAMATI">RANGAMATI</option>
                                    <option value="DHAKA">DHAKA</option>
                                    <option value="FARIDPUR">FARIDPUR</option>
                                    <option value="GAZIPUR">GAZIPUR</option>
                                    <option value="GOPALGANJ">GOPALGANJ</option>
                                    <option value="JAMALPUR">JAMALPUR</option>
                                    <option value="KISHOREGONJ">KISHOREGONJ</option>
                                    <option value="MADARIPUR">MADARIPUR</option>
                                    <option value="MANIKGANJ">MANIKGANJ</option>
                                    <option value="MUNSHIGANJ">MUNSHIGANJ</option>
                                    <option value="MYMENSINGH">MYMENSINGH</option>
                                    <option value="NARAYANGANJ">NARAYANGANJ</option>
                                    <option value="NARSINGDI">NARSINGDI</option>
                                    <option value="NETRAKONA">NETRAKONA</option>
                                    <option value="RAJBARI">RAJBARI</option>
                                    <option value="SHARIATPUR">SHARIATPUR</option>
                                    <option value="SHERPUR">SHERPUR</option>
                                    <option value="TANGAIL">TANGAIL</option>
                                    <option value="BAGERHAT">BAGERHAT</option>
                                    <option value="CHUADANGA">CHUADANGA</option>
                                    <option value="JESSORE">JESSORE</option>
                                    <option value="JHENAIDAH">JHENAIDAH</option>
                                    <option value="KHULNA">KHULNA</option>
                                    <option value="KUSHTIA">KUSHTIA</option>
                                    <option value="MAGURA">MAGURA</option>
                                    <option value="MEHERPUR">MEHERPUR</option>
                                    <option value="NARAIL">NARAIL</option>
                                    <option value="SATKHIRA">SATKHIRA</option>
                                    <option value="BOGRA">BOGRA</option>
                                    <option value="CHAPAINABABGANJ">CHAPAINABABGANJ</option>
                                    <option value="JOYPURHAT">JOYPURHAT</option>
                                    <option value="PABNA">PABNA</option>
                                    <option value="NAOGAON">NAOGAON</option>
                                    <option value="NATORE">NATORE</option>
                                    <option value="RAJSHAHI">RAJSHAHI</option>
                                    <option value="SIRAJGANJ">SIRAJGANJ</option>
                                    <option value="DINAJPUR">DINAJPUR</option>
                                    <option value="GAIBANDHA">GAIBANDHA</option>
                                    <option value="KURIGRAM">KURIGRAM</option>
                                    <option value="LALMONIRHAT">LALMONIRHAT</option>
                                    <option value="NILPHAMARI">NILPHAMARI</option>
                                    <option value="PANCHAGARH">PANCHAGARH</option>
                                    <option value="RANGPUR">RANGPUR</option>
                                    <option value="THAKURGAON">THAKURGAON</option>
                                    <option value="HABIGANJ">HABIGANJ</option>
                                    <option value="MAULVIBAZAR">MAULVIBAZAR</option>
                                    <option value="SUNAMGANJ">SUNAMGANJ</option>
                                    <option value="SYLHET">SYLHET</option>

                                </select>
                            </div>
                            <div class="sign-in">
                                <textarea name="address" rows="4" required placeholder="Your Address"></textarea>
                            </div>
                            <div class="sign-in">
                                <div style="margin-top: 15px; margin-bottom: 10px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="optionsRadios1" value="Male"> <span> Male</span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="optionsRadios1" value="Female"> <span>Female</span>
                                    </label>
                                </div>
                            </div>
                            <div class="sign-in">
                                <input type="submit" value="SIGN UP">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="/js/user/validators/passwordMatch.validator.js">
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
@endsection
