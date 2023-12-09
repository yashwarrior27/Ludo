<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function ReferralReport(Request $request)
    {
        try
        {
        $paginate=isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

        $user=Auth::user();

          $reports=Transaction::with('Game','Game.Winner')
          ->where('trans',4)
          ->where('user_id',$user->id)
          ->where('status',1)
          ->orderBy('id','Desc')
          ->paginate(10);

          $data=$reports->map(function($collect){

                      return ['amount'=>$collect->amount,
                      'from_user'=>$collect->Game->Winner->username,
                      'timestamp'=>$collect->created_at];
          });

          return \ResponseBuilder::successWithPaginate($this->messages['SUCCESS'],$this->success,$reports,$data);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }
}
