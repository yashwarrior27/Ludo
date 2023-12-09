<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Deposit;

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
}
