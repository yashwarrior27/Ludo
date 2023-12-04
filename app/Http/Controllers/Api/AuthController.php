<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function Register(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                     'number'=>'required|numeric|digits:10',
                     'referral'=>'nullable|exists:users,register_id'
            ]);
           if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

           if(User::where('mobile',$request->number)->first())return \ResponseBuilder::fail($this->messages['ALREADY_REGISTER'],$this->badRequest);

           $parent=null;

           if(isset($request->referral)&& !empty($request->referral))
              $parent=User::where('register_id',$request->referral)->first()->id;

           $id=$this->UnqiueID();

          $user= User::create([
              'register_id'=>$id,
              'username'=>$id,
              'mobile'=>$request->number,
              'parent_id'=>$parent,
            ]);

           UserDetail::create(['user_id'=>$user->id]);

        return \ResponseBuilder::success($this->messages['REGISTERED'],$this->success);

        }catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }


    public function Login(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[

                'number'=>'required|numeric|digits:10|exists:users,mobile'
            ],
            ['number.exists'=>'User not registered.']);

            if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user= User::where('mobile',$request->number)->first();

            if($user->status!=1) return \ResponseBuilder::fail($this->messages['BLOCKED'],$this->badRequest);

                $otp=rand(100000,999999);
                $user->otp=$otp;
                $user->save();
               return \ResponseBuilder::success($this->messages['OTP_SUCCESS'],$this->success,['otp'=>$otp]);
        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function OTPVerify(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[

                'number'=>'required|numeric|digits:10|exists:users,mobile',
                'otp'=>'required|numeric|digits:6',
            ],
            ['number.exists'=>'User not registered.']);

        if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

        $user= User::where('mobile',$request->number)->first();

        if($user->status!=1) return \ResponseBuilder::fail($this->messages['BLOCKED'],$this->badRequest);

        if(empty($user->otp) || $user->otp!=$request->otp)
           return \ResponseBuilder::fail($this->messages['INVALID_OTP'],$this->badRequest);

           $user->otp=null;
           $user->save();

           Auth::login($user);

           $token = auth()->user()->createToken('API Token')->accessToken;

           return \ResponseBuilder::successWithToken($this->messages['LOGIN_SUCCESS'],$this->success,$token);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function UserProfile()
    {
        try
        {
            $user=Auth::user();

            $userdetails=UserDetail::where('user_id',$user->id)->first();

            $data=['number'=>$user->mobile,'username'=>$user->username,'aadhar_status'=>$userdetails->status];

             return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);
        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function ChangeUserName(Request $request)
    {
        try
        {
            $user=Auth::user();

            $validator=Validator::make($request->all(),[
                'username'=>'required|string|min:5|unique:users,username,'.$user->id
            ]);
            if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user->username=$request->username;
            $user->save();

           return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function KYCUpdate(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                      'aadhar_front'=>'required|image|size:5000',
                      'aadhar_back'=>'required|image|size:5000',
                      'upi_id'=>'required|regex:/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            ],['upi_id.regex'=>'Invalid UPI ID.']);

            if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $userdetail=UserDetail::where('user_id',$user->id)->first();

            if($userdetail->status=='review')
               return \ResponseBuilder::fail($this->messages['KYC_REVIEW'],$this->badRequest);

            if($userdetail->status=='success')
               return \ResponseBuilder::success($this->messages['KYC_COMPLETED'],$this->success);

            $aadhar_front=$this->uploadDocuments($request->addhar_front,public_path('/assets/images/aadhar/'));
            $aadhar_back=$this->uploadDocuments($request->addhar_back,public_path('/assets/images/aadhar/'));

            $userdetail->aadhar_front=$aadhar_front;
            $userdetail->aadhar_back=$aadhar_back;
            $userdetail->upi_id=$request->upi_id;
            $userdetail->save();

        return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);
        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->badRequest);
        }
    }

    public function KYCData()
    {
        try
        {
            $user=Auth::user();

            $userdetail=UserDetail::where('user_id',$user->id)->first();

            $data=[
                'aadhar_front'=>!empty($userdetail->aadhar_front)?url("/assets/images/aadhar/{$user->aadhar_front}"):null,
                'aadhar_back'=>!empty($userdetail->aadhar_back)?url("/assets/images/aadhar/{$user->aadhar_back}"):null,
                'upi_id'=>$userdetail->upi_id,
                'status'=>$userdetail->status
            ];
            return \ResponseBuilder::success($this->messages['SUCCESS'].$this->success,$data);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

}
