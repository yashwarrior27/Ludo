<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function Index(Request $request)
    {
        try
        {
            $title='Games';

            $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

            $query=Game::with('CreatedUser','AcceptedUser','Category');

            if(isset($request->filter))
            {
               $query->where('status',$request->filter);
            }

            if(isset($request->search) && !empty($request->search))
            {
                $query->where(function($query)use($request){
                    $query->whereHas('Category',function($q)use($request){
                        $q->where('name','like',"%{$request->search}%");
                  })->orWhereHas('CreatedUser',function($q)use($request){
                    $q->where('username','like',"%{$request->search}%");
              })->orWhereHas('AcceptedUser',function($q)use($request){
                $q->where('username','like',"%{$request->search}%");
          })->orWhere('amount','like',"%{$request->search}%")->orWhere('room_code','like',"%{$request->search}%")->orWhereDate('created_at','like',"%{$request->search}%");
                });

            }
            $data=$query->orderBy('id','Desc')->paginate($paginate);

            return view('admin.pages.games.index',compact('data','title'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function GameDetail(Game $game)
    {
        try
        {
            if(!$game->id || $game->status=='0')
               return redirect('/games');

             $title='Game Edit';

           if($game->status=='4' || $game->status=='5')
              $title='Game View';

              $data=$game;

            return view('admin.pages.games.edit',compact('data','title'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function GameDetailUpdate(Request $request,Game $game)
    {

        $request->validate([
             'status'=>'required|in:4,5',
             'winner_user_id'=>'required_if:status,4|in:'.$game?->created_id.','.$game?->accepted_id,
             'penalty_user_id'=>'nullable|in:'.$game?->created_id.','.$game?->accepted_id,
             'penalty_amount'=>'required_with:penalty_user_id|integer',
             'penalty_reason'=>'nullable',
             'comment'=>'nullable'
        ],['status.in'=>'Invalid status','winner_user_id.in'=>'Invalid user Id','penalty_user_id.in'=>'Invalid user Id']);

        try
        {
            DB::beginTransaction();

            $trans=[];

            if($request->status=='5')
            {
               $game->status='5';
               $game->comment=isset($request->comment) && !empty($request->comment)? $request->comment:'Admin cancel the game';
               $game->save();

               Transaction::where('trans',1)->where('type_id',$game->id)->update(['status'=>0]);
            }
            else if($request->status=='4')
            {
                $game->status='4';
                $game->winner_id=$request->winner_user_id;
                $game->comment='Admin success the game';
                $game->winner_amount=$game->amount+($game->amount-($game->amount*$this->feeper/100));
                $game->save();

                $trans[]=[
                    'user_id'=>$request->winner_user_id,
                    'amount'=>$game->amount+($game->amount-($game->amount*$this->feeper/100)),
                    'trans'=>'3',
                    'type_id'=>$game->id,
                    'type'=>'Game_Win',
                ];

                $gUser=User::where('id',$request->winner_user_id)->first();

                    if(!empty($gUser->parent_id))
                    {
                       $trans[]=[
                            'user_id'=>$gUser->parent_id,
                            'amount'=>$game->amount*($this->referral/100),
                            'trans'=>'4',
                            'type_id'=>$game->id,
                            'type'=>'Referral_Bonus'
                            ];
                    }
            }

            if(isset($request->penalty_user_id) && !empty($request->penalty_user_id))
            {
                $trans[]=[
                      'user_id'=>$request->penalty_user_id,
                      'amount'=>$request->penalty_amount,
                      'trans'=>'5',
                      'type_id'=>$game->id,
                      'type'=>isset($request->penalty_reason) && !empty($request->penalty_reason)?$request->penalty_reason:'Game_Penalty'
                ];
            }

            Transaction::insert($trans);

            DB::commit();

            return redirect('/games')->with('success','Status update successful');

        }
        catch(\Exception $e)
        {
                DB::rollBack();
            return $this->ErrorMessage($e);
        }
     }

}
