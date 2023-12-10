<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Game;
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

    public function GameReport(Request $request)
    {
        try
        {
            $paginate=isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

            $user=Auth::user();

            $games=Game::with('CreatedUser','AcceptedUser')->where(function($query)use($user){
                return $query->where('created_id',$user->id)->orWhere('accepted_id',$user->id);
            })->whereIn('status',['4','5'])->orderBy('id','Desc')->paginate($paginate);

            $data=$games->map(function($collect)use($user){

                $data=['created_name'=>$collect->CreatedUser->username,
                'accepted_name'=>$collect->AcceptedUser->username,
                'game_id'=>$collect->id,
                'amount'=>$collect->amount,
                'timestamp'=>$collect->created_at
            ];
             if($collect->status=='5')
             {
                $data['status']='cancelled';
                $dta['reason']=$collect->reason;
             }
             else if($collect->status=='4' && $collect->winner_id==$user->id)
             {
                $data['status']='win';
                $data['amount']=$collect->winner_amount;
             }
             else
             {
                $data['status']='lose';
             }
                return $data;

            });

         return \ResponseBuilder::successWithPaginate($this->messages['SUCCESS'],$this->success,$games,$data);

        }
        catch(\Exception $e){

            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function DepositReport(Request $request)
    {
        try
        {
            $paginate=isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

            $user=Auth::user();

            $deposits=Deposit::with('Deposit','Bonus')->where('user_id',$user->id)->orderBy('id','Desc')->paginate($paginate);

            $data=$deposits->map(function($collect){

               if($collect->status=='success')
                 return [
                'deposit_id'=>$collect->id,
                'amount'=>$collect->Deposit->amount,
                'bonus'=>$collect->Bonus->amount,
                'timestamp'=>$collect->created_at
                 ];
                 else
                  return[
                'deposit_id'=>$collect->id,
                'amount'=>$collect->user_amount,
                'comment'=>$collect->comment,
                'timestamp'=>$collect->created_at
                  ];
            });

            return \ResponseBuilder::successWithPaginate($this->messages['SUCCESS'],$this->success,$deposits,$data);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }

    }
}
