<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $serverError = 500;
    protected $badRequest = 400;
    protected $unauthorized = 401;
    protected $forbidden = 403;
    protected $notFound = 404;
    protected $success = 200;
    protected $noContent = 204;
    protected $partialContent = 206;

    protected $feeper=5;
    protected $referral=3;

    protected $tax=28;

    protected $messages=[
        'OTP_SUCCESS'=>'OTP send successful',
        'BLOCKED'=>'User blocked.Please contact to admin',
        'ALREADY_REGISTER'=>'User already registered',
        'SUCCESS'=>'Successful',
        'REGISTERED'=>'Register successful',
        'INVALID_OTP'=>'Invalid OTP',
        'LOGIN_SUCCESS'=>'Login successful',
        'MULTIPLE'=>'Amount must be multiple of ',
        'GAME_CREATE'=>'Game create successful',
        'ALREADY_GAME'=>'Already in game',
        'INSUFFICIENT'=>'Insufficient balance',
       'UNAUTHORIZED'=>'Unauthorized user',
        'ALREADY_STARTED'=>'Already game started',
        'MATCHING'=>'Matching is ongoing',
        'SOMETHING'=>'Something went wrong',
        'STARTED'=>'Game started. ',
        'CANCELLED'=>'Game is cancelled',
        'INVALID_GAME'=>'Game is invalid',
        'ALREADY_ROOM_CODE'=>'Already have a room code',
        'COMPLETED'=>'Game is completed',
        'INVALID_STATUS'=>'Invalid game status',
        'ALREADY_STATUS'=>'Already status updated',
        'KYC_REVIEW'=>'Details in under review',
        'KYC_COMPLETED'=>'KYC is completed',
        'NO_DATA'=>'No data found',
        'ALREADY_PENDING'=>'Already have pending request',
        'NEED_KYC'=>'Please complete your kyc first',
        'WITHDRAWAL'=>'Added withdrawal request',

    ];

    public function ErrorMessage($e){

      return $e->getMessage();
    }

    public function uploadDocuments($files, $path)
    {

        $imageName = substr(time(),-5). $files->getClientOriginalName();
        $files->move($path, $imageName);
        return $imageName;
    }

    public function UnqiueID()
    {
        $Id='LB'.rand(1000,9999).rand(10,99);
        $user=User::where('username',$Id)->orWhere('register_id',$Id)->first();
        if(!$user)
           return $Id;
        else
           return $this->UnqiueID();
    }


}
