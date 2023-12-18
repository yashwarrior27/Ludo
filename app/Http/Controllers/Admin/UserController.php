<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Game;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Index(Request $request)
    {
        try
        {

         $title='Users';

         $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

         $query=User::with('UserDetail','Parent');

         if(isset($request->filter))
         {
            $query->where('status',$request->filter);
         }

         if(isset($request->search) && !empty($request->search))
         {
             $query->where(function($query)use($request){
                 $query->whereHas('UserDetail',function($q)use($request){
                     $q->where('status','like',"%{$request->search}%");
               })->orWhereHas('Parent',function($q)use($request){
                $q->where('mobile','like',"%{$request->search}%");
          })->orWhere('username','like',"%{$request->search}%")->orWhere('mobile','like',"%{$request->search}%")->orWhere('created_at','like',"%{$request->search}%");
             });

         }
         $data=$query->orderBy('id','Desc')->paginate($paginate);

         return view('admin.pages.users.index',compact('data','title'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function UserEdit(User $user)
    {
        try
        {
            $title='User Edit';
            $result=$user;
          return view('admin.pages.users.create',compact('result','title'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function UserUpdate(Request $request,User $user)
    {
        $request->validate(['status'=>'required']);
        try
        {
            $user->status=$request->status;
            $user->save();

            return redirect('/users')->with('success','Update successful');

        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function UserView(User $user)
    {
        try
        {
            $userDetails=UserDetail::where('user_id',$user->id)->first();
            $deposits=Deposit::with('User')->where('user_id',$user->id)->orderBy('id','Desc')->get();
            $games=Game::with('CreatedUser','AcceptedUser','Category')->where(function($query)use($user){
                   return $query->where('created_id',$user->id)->orWhere('accepted_id',$user->id);
            })->orderBy('id','Desc')->get();
            $withdrawals=Withdrawal::with('User','User.UserDetail')->where('user_id',$user->id)->orderBy('id','Desc')->get();
            return view('admin.pages.users.show',compact('user','userDetails','deposits','games','withdrawals'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }
}
