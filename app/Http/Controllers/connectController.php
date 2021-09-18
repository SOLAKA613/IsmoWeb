<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class connectController extends Controller
{
    public function register_Conn(Request $request){

        $this->validate($request, [
            'username'  => 'required|min:3|max:25',
            'password'  => 'required|min:8|max:25',
            'confirm_password'  => 'required|min:8|max:25',
            'email' => ['required','email:rfc,dns']
        ]);

        $user = User::whereName($request->username)->whereEmail($request->email)->first();
        if($user != null && Hash::check($request->password, $user->password)){
            if($user->register == null){
                $request->session()->put('user',$user->name);
                $user->register = 1;
                $user->save();
                return redirect("index");
            }else{
                return redirect()->back()->with("erreur","You are already registered please connect to your account!");
            }
        }else{
            return redirect()->back()->with("erreur","You cannot register because you are not registered by the admin!");
        }
    }

    public function connect(Request $request){

        $credentials = $request->validate([
            'name'  => 'required|min:3|max:25',
            'password'  => 'required|min:8|max:25',
        ]);
        $user = User::whereName($request->name)->first();
        if($user != null && Hash::check($request->password, $user->password)){
            if($user->register == 1){
                $request->session()->put('user',$user->name);
                return redirect("index");
            }else{
                return redirect()->back()->withErrors("erreur","Please register before connecting to your account!");
            }
        }else{
            return redirect()->back()->withErrors("erreur","The password or username is incorrect!");
        }

    }

    public function out(Request $request){

        $value = $request->session()->pull('user', 'default');

        return redirect('/');

    }

}
