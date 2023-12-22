<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
   public function Index(Request $request)
   {
    try
    {
        $title='Withdrawals';

        $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

        $query=Withdrawal::with('User');

        if(isset($request->filter))
        {
           $query->where('status',$request->filter);
        }

        if(isset($request->search) && !empty($request->search))
        {
            $query->where(function($query)use($request){
                $query->whereHas('User',function($q)use($request){
                    $q->where('mobile','like',"%{$request->search}%");
              })->orWhere('amount','like',"%{$request->search}%")->orWhere('upi_id','like',"%{$request->search}%")->orWhere('transaction_id','like',"%{$request->search}%")->orWhere('created_at','like',"%{$request->search}%")->orWhere('comment','like',"%{$request->search}%");
            });

        }
        $data=$query->orderBy('id','Desc')->paginate($paginate);

        return view('admin.pages.withdrawals.index',compact('data','title'));

    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }
   }

   public function WithdrawalEdit(Withdrawal $withdrawal)
   {
    try
    {
        if($withdrawal->status!='pending') return redirect('/withdrawals');

        $title='Withdrawal Edit';

       return view('admin.pages.withdrawals.create',compact('title','withdrawal'));
    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }
   }

   public function WithdrawalUpdate(Request $request , Withdrawal $withdrawal)
   {
    $request->validate([
         'status'=>'required|in:success,rejected',
         'transaction_id'=>'required_if:status,success',
         'comment'=>'nullable'
    ]);
    try
    {
        $withdrawal->status=$request->status;
        $withdrawal->transaction_id=$request->transaction_id;
        $withdrawal->comment=$request->comment;
        $withdrawal->save();

        if($request->status=='rejected')
           Transaction::where('user_id',$withdrawal->user_id)->where('trans',6)->where('type_id',$withdrawal->id)->update(['status'=>0]);
           else
           {
               $user=User::findOrFail($withdrawal->user_id);
               $user->winning_wallet-=$withdrawal->amount;
               $user->save();
           }


      return redirect('/withdrawals')->with('success','Update successful.') ;
    }
    catch(\Exception $e)
    {
       return $this->ErrorMessage($e);
    }
   }
}
