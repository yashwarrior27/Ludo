<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FakeGame;
use Illuminate\Http\Request;

class FakeGameController extends Controller
{
    public function Index(Request $request)
    {
        try
        {
            $title='Fake Games';

            $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

            $query=FakeGame::with('Category');

            if(isset($request->search) && !empty($request->search))
            {
                $query->where(function($query)use($request){
                    $query->whereHas('Category',function($q)use($request){
                        $q->where('name','like',"%{$request->search}%");
                  })->orWhere('amount','like',"%{$request->search}%")->orWhere('created_user','like',"%{$request->search}%")->orWhere('accepted_user','like',"%{$request->search}%")->orWhereDate('created_at','like',"%{$request->search}%");
                });
            }

            $data=$query->orderBy('id','Desc')->paginate($paginate);

            return view('admin.pages.fakegame.index',compact('data','title'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

}
