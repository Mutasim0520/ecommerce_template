@if(Session::has('success_link_share'))
    <div class="modal fade success-popup" id="success_link_share" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/checkcircle.png">
                    <p class="lead">{{Session::get('success_link_share')}}</p>
                    <a href="/" class="rd_more btn btn-success" style="margin-bottom: 20px">Go to Home</a>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('registration_confirmation'))
    <div class="modal fade success-popup" id="registration_confirmation" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/checkcircle.png">
                    <p class="lead">{{Session::get('registration_confirmation')}}</p>
                    <a href="/" class="rd_more btn btn-success" style="margin-bottom: 20px">Go to Home</a>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('correct_email_reset'))
    <div class="modal fade success-popup" id="correct_email_reset" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/checkcircle.png">
                    <p class="lead">{{Session::get('correct_email_reset')}}</p>
                    <a href="/" class="rd_more btn btn-success" style="margin-bottom: 20px">Go to Home</a>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('false_email_reset'))
    <div class="modal fade success-popup" id="false_email_reset" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/error.png">
                    <p class="lead">{{Session::get('false_email_reset')}}</p>
                    <a href="/" class="rd_more btn btn-success" style="margin-bottom: 20px">Go to Home</a>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('success_password_reset'))
    <div class="modal fade success-popup" id="success_password_reset" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/checkcircle.png">
                    <p class="lead">{{Session::get('success_password_reset')}}</p>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('success_subscriber_message'))
    <div class="modal fade success-popup" id="success_subscriber_message" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/checkcircle.png">
                    <p class="lead">{{Session::get('success_subscriber_message')}}</p>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('unauth_success_subscriber'))
    <div class="modal fade success-popup" id="unauth_success_subscriber" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/checkcircle.png">
                    <p class="lead">{{Session::get('unauth_success_subscriber')}}</p>
                </div>
            </div>
        </div>
    </div>
@endif
@if(Session::has('subscriber_exist'))
    <div class="modal fade success-popup" id="subscriber_exist" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center">Thank You !</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="/images/user/icon/checkcircle.png">
                    <p class="lead">{{Session::get('subscriber_exist')}}</p>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('auth_required'))
    <div class="modal fade success-popup" id="auth_required" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="/images/user/icon/exclamation-xxl.png">
                    <p class="lead">{{Session::get('auth_required')}}</p>
                </div>
            </div>
        </div>
    </div>
@endif