<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

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
}
