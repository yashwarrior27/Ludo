<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
   public function Index(Request $request)
   {
       try
       {

        $title='Deposits';

        $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

        $query=Deposit::with('User');

        if(isset($request->filter))
        {
           $query->where('status',$request->filter);
        }

        if(isset($request->search) && !empty($request->search))
        {
            $query->where(function($query)use($request){
                $query->whereHas('User',function($q)use($request){
                    $q->where('mobile','like',"%{$request->search}%");
              })->orWhere('user_amount','like',"%{$request->search}%")->orWhere('amount','like',"%{$request->search}%")->orWhere('created_at','like',"%{$request->search}%");
            });

        }
        $data=$query->orderBy('id','Desc')->paginate($paginate);

        return view('admin.pages.deposits.index',compact('data','title'));
       }
       catch(\Exception $e)
       {
           return $this->ErrorMessage($e);
       }
   }

   public function EditDeposit(Deposit $deposit)
   {
       try
       {
           if(!$deposit || $deposit->status!='pending')
              return redirect('/deposits');

           $title='Deposit Edit';
           $data=$deposit;
         return view('admin.pages.deposits.edit',compact('title','data'));
       }
       catch(\Exception $e)
       {
           return $this->ErrorMessage($e);
       }
   }

   public function UpdateDeposit(Request $request,Deposit $deposit)
   {
       $request->validate([
             'amount'=>'required_if:status,success|integer',
             'status'=>'required|in:success,rejected',
             'comment'=>'nullable'
       ]);
       try
       {
           DB::beginTransaction();

           if($request->status=='success')
           {
               $deposit->status='success';
               $deposit->amount=$request->amount;
               $deposit->comment=isset($request->comment) && !empty($request->comment)?$request->comment:null;
               $deposit->save();

               $amount=($request->amount/($this->tax+100))*100;

               $data=[[
                 'user_id'=>$deposit->user_id,
                 'amount'=>$amount,
                 'trans'=>0,
                 'type_id'=>$deposit->id,
                 'type'=>'Deposit',
               ],
               [
                   'user_id'=>$deposit->user_id,
                   'amount'=>$request->amount-$amount,
                   'trans'=>2,
                   'type_id'=>$deposit->id,
                   'type'=>'Deposit_Bonus',
               ]
               ];

               Transaction::insert($data);
           }
           else
           {
               $deposit->status='rejected';
               $deposit->comment=isset($request->comment) && !empty($request->comment)?$request->comment:null;
               $deposit->save();
           }

           DB::commit();

           return redirect('/deposits')->with('success','Update successful');

       }
       catch(\Exception $e)
       {
           DB::rollBack();
           return $this->ErrorMessage($e);
       }
   }
}
