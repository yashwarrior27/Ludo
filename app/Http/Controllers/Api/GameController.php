<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{


    public function SetGame(Request $request)
    {
        try
        {
            $user=Auth::user();

            $checkgame=Game::where('created_id',$user->id)->orWhere('accepted_id',$user->id)->orderBy('id','Desc')->first();

            if($checkgame && !in_array($checkgame->status,['3','4','5']))
               return \ResponseBuilder::fail($this->messages['ALREADY_GAME'],$this->badRequest);

            $validator= Validator::make($request->all(),[
                'amount'=>'required|integer|min:50',
                'category_id'=>'required|numeric|exists:categories,id'
            ]);
            if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            if((int)$request->amount%10!=0)
             return \ResponseBuilder::fail($this->messages['MULTIPLE'],$this->badRequest);

            if(($user->deposit_wallet+$user->winning_wallet)<$request->amount)
               return \ResponseBuilder::fail($this->messages['INSUFFICIENT'],$this->badRequest);

            $game =Game::create([
               'created_id'=>$user->id,
               'category_id'=>$request->category_id,
               'amount'=>$request->amount,
            ]);

            $data=['id'=>$game->id,'amount'=>$game->amount];

          return \ResponseBuilder::success($this->messages['GAME_CREATE'],$this->success,$data);
        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function OpenBattle()
    {
        try
        {
            $user=Auth::user();

            $games=Game::selectRaw("users.username as username,games.amount as amount,games.id as id,CAST((games.amount + (games.amount-(games.amount*{$this->feeper}/100))) AS DECIMAL(20,3)) as price")->join('users','games.created_id','=','users.id')
                        ->where('games.created_id','!=',$user->id)
                        ->whereNull('games.accepted_id')
                        ->where('games.status','0')
                        ->orderBy('games.id','Desc')
                        ->get()->toArray();

            return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$games);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

}
