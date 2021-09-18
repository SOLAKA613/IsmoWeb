<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function reset(Request $request){

        $this->validate($request, [
            'password'  => 'required|min:8|max:25',
            'password_confirmation'  => 'required|min:8|max:25',
            'email' => ['required','email:rfc,dns']
        ]);

        $user = User::whereEmail($request->email);
        $upd = $user->update(['password' => Hash::make($request->password)]);

        if($upd == 1){
        //    $request->session()->put('user',$user->name);
            return redirect("index");
        }else{
            return back()->with("erreur","Error when resetting password!");
        }
    }
}
