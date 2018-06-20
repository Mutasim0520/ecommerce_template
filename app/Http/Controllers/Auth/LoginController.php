<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\SocialAccountService;
use App\User as User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try{
            $socialUser = Socialite::driver('facebook')->user();

        }
        catch(\Exception $e) {
            return redirect('/');
        }

        $user = User::where('facebook_id', $socialUser->getId())->first();
        if(!$user){
            if($socialUser->getEmail()){
                $mail = $socialUser->getEmail();
            }
            else{
                $mail = "example@facebook.com";
            }
            User::create([
                'facebook_id' => $socialUser->getId(),
                'name' => $socialUser->getName(),
                'email' => $mail,
            ]);
            
            $user = User::where('facebook_id', $socialUser->getId())->first();

        }
        if(Auth::loginUsingId($user->id)){
            return redirect()->intended('/');
        }
    }
        // $user->token;
}
