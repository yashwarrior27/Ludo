<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Deposit;
use App\Models\Game;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function Index()
    {
        try
        {
            $data=[];

            $data['total_deposits']=Deposit::where('status','success')->sum('amount');
            $data['total_withdrawals']=Withdrawal::where('status','success')->sum('amount');
            $data['total_win']=Game::where('status','4')->sum('winner_amount');
            $data['total_user']=User::query()->count();
            $data['today_deposit']=Deposit::where('status','success')->whereDate('created_at',date('Y-m-d'))->sum('amount');
            $data['today_withdrawal']=Withdrawal::where('status','success')->whereDate('created_at',date('Y-m-d'))->sum('amount');
            $data['today_win']=Game::where('status','4')->whereDate('created_at',date('Y-m-d'))->sum('winner_amount');
            $data['today_user']=User::whereDate('created_at',date('Y-m-d'))->count();


           return view('admin.pages.dashboard.index',compact('data'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function RoleUpdate(Request $request)
    {

        $request->validate([
            'role'=>'required|in:1,2,3,4,5',
            'password'=>'required|string|min:8',
            'confirm_password'=>'required|same:password'
        ]);

        try
        {

            $user=Admin::findOrFail($request->role);

            $user->password=Hash::make($request->password);
            $user->save();

            return redirect('/dashboard')->with('Update successful');
        }
        catch(\Exception $e)
         {
            return $this->ErrorMessage($e);
         }
    }
}
