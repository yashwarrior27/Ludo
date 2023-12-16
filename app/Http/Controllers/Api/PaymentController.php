<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\UserDetail;
use App\Models\Withdrawal;

class PaymentController extends Controller
{
     public function DepositData()
   {
    try
    {
         $setting=Setting::whereIn('key',['qr_code','upi_id'])->get();

           $data=[];
         foreach($setting as $key=>$value)
         {
            if($value->key=='qr_code')
                $data[$value->key]=url("/assets/images/{$value->value}");
            else
               $data[$value->key]=$value->value;
         }

         if(count($data)==0)
         return \ResponseBuilder::success($this->messages['NO_DATA'],$this->success,[]);

         return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);

    }
    catch(\Exception $e)
    {
        return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
    }

   }

    public function MakeDeposit(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                 'amount'=>'required|integer|min:10',
                 'image'=>'required|image|max:5000'
            ]);

          if($validator->fails())
             return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

          $user=Auth::user();

        //   $userDetail=UserDetail::where('user_id',$user->id)->first();

        //   if($request->amount > 500 && (!$userDetail || $userDetail->status!=='success'))
        //          return \ResponseBuilder::fail($this->messages['NEED_KYC'],$this->badRequest);

          if(Deposit::where('user_id',$user->id)->where('status','pending')->first())
             return \ResponseBuilder::fail($this->messages['ALREADY_PENDING'],$this->badRequest);



          $image=$this->uploadDocuments($request->image,public_path('/assets/images/deposits/'));

           Deposit::create([
              'user_id'=>$user->id,
              'user_amount'=>$request->amount,
              'image'=>$image,
           ]);

         return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function Withdrawal(Request $request)
 {
      try
    {

         $validator=Validator::make($request->all(),[
                 'amount'=>'required|integer|min:95'
            ]);

        if($validator->fails())
           return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

        if((int)$request->amount%5!==0)
           return \ResponseBuilder::fail($this->messages['MULTIPLE'].'5.',$this->badRequest);

        $user=Auth::user();

        $userDetail=UserDetail::where('user_id',$user->id)->first();

        if($request->amount >500 && (!$userDetail || $userDetail->status!='success'))
           return \ResponseBuilder::fail($this->messages['NEED_KYC'],$this->badRequest);

        if($user->WithdrawalableAmount()<(int)$request->amount)
           return \ResponseBuilder::fail($this->messages['INSUFFICIENT'],$this->badRequest);

        if(Withdrawal::where('user_id',$user->id)->where('status','pending')->first())
           return \ResponseBuilder::fail($this->messages['ALREADY_PENDING'],$this->badRequest);

          $withdrawal= Withdrawal::create([
               'user_id'=>$user->id,
               'amount'=>$request->amount,
           ]);

           Transaction::create([
               'user_id'=>$user->id,
               'amount'=>$request->amount,
               'trans'=>'6',
               'type_id'=>$withdrawal->id,
               'type'=>'Withdrawal'
           ]);

        return \ResponseBuilder::success($this->messages['WITHDRAWAL'],$this->success);
    }
     catch(\Exception $e)
    {
        return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
    }
 }

 public function WithdrawalableAmount()
 {
    try
    {
        $user=Auth::user();
        $data=['withdrawalable_amount'=>$user->WithdrawalableAmount()];
        return \ResponseBuilder::success($this->messages['success'],$this->success,$data);
    }
    catch(\Exception $e)
    {
        return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
    }

 }
}
