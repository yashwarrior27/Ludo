<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\GameResult;

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

            if($user->TotalBalance()<$request->amount)
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

    public function OpenBattle(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                 'category_id'=>'required|exists:categories,id'
            ]);

            if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $games=Game::selectRaw("users.username as username,games.amount as amount,games.id as id,CAST((games.amount + (games.amount-(games.amount*{$this->feeper}/100))) AS DECIMAL(20,3)) as prize")->join('users','games.created_id','=','users.id')
                        ->where('games.created_id','!=',$user->id)
                        ->whereNull('games.accepted_id')
                        ->where('games.status','0')
                        ->where('category_id',$request->category_id)
                        ->orderBy('games.id','Desc')
                        ->get()->toArray();

            return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$games);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function PlayGame(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                'game_id'=>'required|exists:games,id,accepted_id,NULL,deleted_at,NULL'
            ]);

            if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $checkgame=Game::where('created_id',$user->id)->orWhere('accepted_id',$user->id)->orderBy('id','Desc')->first();

            if($checkgame && !in_array($checkgame->status,['3','4','5']))
               return \ResponseBuilder::fail($this->messages['ALREADY_GAME'],$this->badRequest);

               $game= Game::findOrFail($request->game_id);

            if($user->TotalBalance() < $game->amount)
               return \ResponseBuilder::fail($this->messages['INSUFFICIENT'],$this->badRequest);


            $game->accepted_id=$user->id;
            $game->save();

            return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);
        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function CurrentGame(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                'category_id'=>'required|exists:categories,id'
           ]);

           if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $games=Game::with('AcceptedUser','CreatedUser')->whereNotIn('status',['4','5'])->where(function($query)use($user){return $query->where('accepted_id',$user->id)->orWhere('created_id',$user->id);})->orderBy('id','Desc')->get();

            if($games->count()==0)return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,[]);

            $data=[];
            foreach($games as $key=>$game)
            {

            if($game->accepted_id==$user->id)
            {
                $data[]=[
                    'type'=>0,
                    'own_name'=>$game->AcceptedUser->username,
                    'amount'=>number_format($game->amount,3),
                    'prize'=>number_format($game->amount+($game->amount-($game->amount*$this->feeper/100)),3),
                    'game_id'=>$game->id,
                    'username'=>$game->CreatedUser->username,
                    'status'=>$game->status];
            }
            else
            {
                $data[]=[
                    'type'=>1,
                    'own_name'=>$game->CreatedUser->username,
                    'amount'=>number_format($game->amount,3),
                    'prize'=>number_format($game->amount+($game->amount-($game->amount*$this->feeper/100)),3),
                    'game_id'=>$game->id,
                    'username'=>!empty($game->accepted_id)?$game->AcceptedUser->username:null,
                    'status'=>!empty($game->accepted_id)?$game->status:null];
            }
        }

       return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

     public function RejectGame(Request $request)
     {
         try
         {
             $validator=Validator::make($request->all(),['game_id'=>'required|exists:games,id,deleted_at,NULL']);

            if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $game=Game::findOrFail($request->game_id);

            if($game->status!=0)return \ResponseBuilder::fail($this->messages['ALREADY_GAME'],$this->badRequest);

            if($game->created_id==$user->id || $game->accepted_id==$user->id)
            {
                $game->accepted_id=null;
                $game->save();

                return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);
            }
            else
            {
              return \ResponseBuilder::fail($this->messages['UNAUTHORIZED'],$this->badRequest);
            }
         }
         catch(\Exception $e)
         {
             return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
         }
     }

     public function DeleteGame(Request $request)
     {
         try
         {
            $validator=Validator::make($request->all(),['game_id'=>'required|exists:games,id,deleted_at,NULL']);

            if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $game=Game::findOrFail($request->game_id);

            if($game->status!=0)return \ResponseBuilder::fail($this->messages['ALREADY_GAME'],$this->badRequest);

            if($game->created_id==$user->id)
            {
                $game->delete();

                return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);
            }
             else
            {
              return \ResponseBuilder::fail($this->messages['UNAUTHORIZED'],$this->badRequest);
            }
         }
         catch(\Exception $e)
         {
             return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
         }
     }

    public function StartGame(Request $request)
    {
        try
        {  DB::beginTransaction();

            $validator=Validator::make($request->all(),['game_id'=>'required|exists:games,id,deleted_at,NULL']);

            if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $game=Game::findOrFail($request->game_id);

            if($user->id != $game->created_id) return \ResponseBuilder::fail($this->messages['UNAUTHORIZED'],$this->badRequest);

            if(empty($game->accepted_id)) return \ResponseBuilder::fail($this->messages['MATCHING'],$this->badRequest);

            if($game->status=='5')
               return \ResponseBuilder::fail($this->messages['CANCELLED'],$this->badRequest);

            if($game->status!='0')
               return \ResponseBuilder::fail($this->messages['ALREADY_STARTED'],$this->badRequest);

           if($user->TotalBalance()<$game->amount || $game->AcceptedUser->TotalBalance()<$game->amount)
           {
               $game->comment='Insufficient Balance.';
               $game->status='5';
               $game->save();

               DB::commit();
               return \ResponseBuilder::fail($this->messages['SOMETHING'],$this->badRequest);
           }

             Transaction::insert([[
                 'user_id'=>$game->created_id,
                 'amount'=>$game->amount,
                 'trans'=>  1,
                 'type_id'=>$game->id,
                 'type'=>'Play_Game',
             ],[
                'user_id'=>$game->accepted_id,
                'amount'=>$game->amount,
                'trans'=>  1,
                'type_id'=>$game->id,
                'type'=>'Play_Game',
            ]]);

            $game->status='1';
            $game->room_code_timer=time()+300;
            $game->save();

            DB::commit();

            return \ResponseBuilder::success($this->messages['STARTED'],$this->success);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function RoomCode(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                 'game_id'=>'required|exists:games,id,deleted_at,NULL',
            ]);
            if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $game=Game::findOrFail($request->game_id);

            if($game->status==5)return \ResponseBuilder::fail($this->messages['CANCELLED'],$this->badRequest);

            if($game->status==4) return \ResponseBuilder::fail($this->messages['COMPLETED'],$this->badRequest);

            if($game->created_id==$user->id)
            {
                $data=[
                    'own_name'=>$user->username,
                    'user_name'=>$game->AcceptedUser->username,
                    'prize'=>number_format($game->amount+($game->amount-($game->amount*$this->feeper/100)),3),
                    'status'=>$game->status,
                    'type'=>1,
                    'result'=>0
                ];

                $gameresult=GameResult::where('game_id',$game->id)->where('user_id',$user->id)->first();

                if($gameresult)
                {
                    $data['result']=1;
                    $data['result_status']=$gameresult->status;
                    $data['result_reason']=$gameresult->reason;
                    $data['result_time']=$gameresult->created_at;
                }

                if(!empty($game->room_code))
                {
                    $data['room_code']=$game->room_code;

                    if($game->status=='1')
                    $data['accepter_timer']=$game->accepter_timer;

                    return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);
                }
                else
                {
                    $data['room_code_timer']=$game->room_code_timer;

                    return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);
                }
            }
            else if($game->accepted_id==$user->id)
            {
                $data=[
                    'own_name'=>$user->username,
                    'user_name'=>$game->CreatedUser->username,
                    'prize'=>number_format($game->amount+($game->amount-($game->amount*$this->feeper/100)),3),
                    'status'=>$game->status,
                    'type'=>0,
                    'result'=>0
                ];

                $gameresult=GameResult::where('game_id',$game->id)->where('user_id',$user->id)->first();

                if($gameresult)
                {
                    $data['result']=1;
                    $data['result_status']=$gameresult->status;
                    $data['result_reason']=$gameresult->reason;
                    $data['result_time']=$gameresult->created_at;
                }

                if(!empty($game->room_code))
                {
                    if( (int) $game->status > 1)
                       $data['room_code']=$game->room_code;
                    else
                      $data['accepter_timer']=$game->accepter_timer;

                    return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);
                }

                else
                {
                    $data['room_code_timer']=$game->room_code_timer;

                    return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);
                }

            }
            else
            {
                return \ResponseBuilder::fail($this->messages['UNAUTHORIZED'],$this->badRequest);
            }

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function SetRoomCode(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                'game_id'=>'required|exists:games,id,deleted_at,NULL',
                'room_code'=>'required|numeric|regex:/^0\d{7}$/'
            ],['room_code.regex'=>'Invalid room code.']);

            if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $game=Game::where('id',$request->game_id)->where('status','1')->first();

            if(!$game) return \ResponseBuilder::fail($this->messages['INVALID_GAME'],$this->badRequest);

            if($game->created_id != $user->id) return \ResponseBuilder::fail($this->messages['UNAUTHORIZED'],$this->badRequest);

            if(!empty($game->room_code)) return \ResponseBuilder::fail($this->messages['ALREADY_ROOM_CODE'],$this->badRequest);

           $game->room_code=$request->room_code;
           $game->accepter_timer=time()+120;
           $game->save();

           return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);
        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function AcceptRoomCode(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),['game_id'=>'required|exists:games,id,deleted_at,NULL']);

           if($validator->fails()) return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

           $user=Auth::user();

           $game=Game::where('id',$request->game_id)->where('status','1')->first();

           if(!$game) return \ResponseBuilder::fail($this->messages['INVALID_GAME'],$this->badRequest);

           if($game->accepted_id != $user->id || empty($game->room_code)) return \ResponseBuilder::fail($this->messages['UNAUTHORIZED'],$this->badRequest);

           $game->status='2';
           $game->save();

           return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

    public function StatusUpdate(Request $request)
    {
        try
        {   DB::beginTransaction();

            $validator=Validator::make($request->all(),[
                'game_id'=>'required|exists:games,id,deleted_at,NULL',
                'type'=>'required|in:W,L,C',
                'image'=>'required_if:type,W|image|max:5000',
                'reason'=>'required_if:type,C|string'
            ]);

            if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

            $user=Auth::user();

            $game=Game::findOrFail($request->game_id);

            if($game->status=='4' || $game->status=='5')
               return \ResponseBuilder::fail($this->messages['ALREADY_STATUS'],$this->badRequest);

            if($game->created_id!=$user->id && $game->accepted_id !=$user->id)
               return \ResponseBuilder::fail($this->messages['UNAUTHORIZED'],$this->badRequest);

            $gameResult=GameResult::where('game_id',$game->id)->where('user_id',$user->id)->first();

            if($gameResult)
                return \ResponseBuilder::fail($this->messages['ALREADY_STATUS'],$this->badRequest);

             if($request->type=='C')
             {
                 $gameresult=GameResult::where('game_id',$game->id)->first();

                 GameResult::create([
                      'game_id'=>$game->id,
                      'user_id'=>$user->id,
                      'status'=>'cancel'
                 ]);


              if($game->status=='1' || ($gameresult && $gameresult->status=='cancel'))
              {
                  $game->status='5';
                  $game->comment=$request->reason;
                  $game->save();

                Transaction::where('trans',1)->where('type_id',$game->id)->update(['status'=>0]);
              }else
              {
                 $game->status='3';
                 $game->save();
              }

             }
             else
             {
                if($game->status!='2' && $game->status!='3')
                return \ResponseBuilder::fail($this->messages['INVALID_STATUS'],$this->badRequest);

                $gameresult=GameResult::where('game_id',$game->id)->first();


                if($request->type=='L')
                {
                    GameResult::create([
                        'game_id'=>$game->id,
                        'user_id'=>$user->id,
                        'status'=>'lose',
                      ]);

                    if(!$gameresult){
                     $game->status='3';
                     $game->save();
                    }
                    else
                    {
                        if($gameResult->status=='win')
                        {
                            $game->status='4';
                            $game->winner_id=$gameresult->user_id;
                            $game->save();

                            Transaction::create([
                            'user_id'=>$gameresult->user_id,
                            'amount'=>$game->amount+($game->amount-($game->amount*$this->feeper/100)),
                            'trans'=>'3',
                            'type_id'=>$game->id,
                            'type'=>'Game_Win',
                            ]);

                            $gUser=User::where('id',$gameresult->user_id)->first();

                            if(!empty($gUser->parent_id))
                            {
                                Transaction::create([
                                    'user_id'=>$gUser->parent_id,
                                    'amount'=>$game->amount*($this->referral/100),
                                    'trans'=>'4',
                                    'type_id'=>$game->id,
                                    'type'=>'Referral_Bonus'
                                    ]);
                            }
                        }
                    }
                 }
                 else
                 {

                    $wimage=$this->uploadDocuments($request->image,public_path('/assets/images/win_game/'));

                    GameResult::create([
                        'game_id'=>$game->id,
                        'user_id'=>$user->id,
                        'status'=>'win',
                        'image'=>$wimage
                    ]);

                    if(!$gameresult){
                        $game->status='3';
                        $game->save();
                       }
                       else
                       {
                           if($gameresult->status=='lose')
                           {

                            $game->status='4';
                            $game->winner_id=$user->id;
                            $game->save();

                            Transaction::create([
                                'user_id'=>$user->id,
                                'amount'=>$game->amount+($game->amount-($game->amount*$this->feeper/100)),
                                'trans'=>'3',
                                'type_id'=>$game->id,
                                'type'=>'Game_Win',
                                ]);


                            if(!empty($user->parent_id))
                            {
                                Transaction::create([
                                    'user_id'=>$user->parent_id,
                                    'amount'=>$game->amount*($this->referral/100),
                                    'trans'=>'4',
                                    'type_id'=>$game->id,
                                    'type'=>'Referral_Bonus'
                                    ]);
                            }
                           }

                       }
                 }

             }
             DB::commit();

             return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success);

        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }

     public function RunningBattle(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                'category_id'=>'required|exists:categories,id'
            ]);

            if($validator->fails())return \ResponseBuilder::fail($validator->errors()->first(),$this->badRequest);

              $paginate=isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

              $game=Game::selectRaw("cuser.username as created_user,auser.username as accepted_user,games.amount as amount,CAST((games.amount + (games.amount-(games.amount*{$this->feeper}/100))) AS DECIMAL(20,3)) as prize")->join(DB::raw('users as cuser'),'games.created_id','cuser.id')->join(DB::raw('users as auser'),'games.accepted_id','auser.id')->whereIn('games.status',['1','2'])->orderBy('games.id','Desc')->paginate($paginate);

            $data=$game->toArray()['data'];

            return \ResponseBuilder::successWithPaginate($this->messages['SUCCESS'],$this->success,$game,$data);

        }
        catch(\Exception $e)
        {
            return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
        }
    }
}
