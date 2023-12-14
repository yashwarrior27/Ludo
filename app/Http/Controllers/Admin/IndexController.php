<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function Index()
    {
        if(Auth::check())
           Auth::logout();

        return view('auth.login');
    }

    public function Login(Request $request)
    {
        $request->validate([
               'email'=>'required|exists:admins,email',
               'password'=>'required'
        ]);
        try
        {
            $user=Admin::where('email',$request->email)->first();

            if($user->status!='1') return redirect()->back()->with('error','User is blocked');

            if(!Hash::check($request->password,$user->password))
               return redirect()->back()->with('error','Invalid credentials');

            Auth::login($user);

           return redirect('/dashboard')->with('success','Login successful');

        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function Logout()
    {
        try
        {
            Auth::logout();
            return redirect('/')->with('success','Logout successful.');
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }

    }
}
