<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Auth;

class CreateUserController extends Controller
{
    use RegistersUsers;
    protected function redirectTo()
    {
        if(Auth::guard('admin')->check()) return '/admin/index';
        else if(Auth::guard('employee')->check()) return '/employee/dashboard';
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'district' => 'required',
            'gender' => 'required',
            'mobile' => 'required',
        ]);
    }
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'district' =>$data['district'],
            'mobile' => $data['mobile'],
            'gender'=>$data['gender'],
        ]);
    }
}
