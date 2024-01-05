<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function Create()
    {
        try
        {
            $title='Create Fake Game';
            $category=Category::where('status',1)->get();

            return view('admin.pages.fakegame.create',compact('title','category'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }

    }

    public function Store(Request $request)
    {
        $request->validate([
             'created_user'=>'required|string|min:4',
             'accepted_user'=>'required|string|min:4',
             'amount'=>'required|numeric|min:50',
             'category'=>'required|exists:categories,id'
        ]);
        try
        {
            FakeGame::create([
                    'created_user'=>$request->created_user,
                    'accepted_user'=>$request->accepted_user,
                    'amount'=>$request->amount,
                    'category_id'=>$request->category
            ]);

           return redirect('/fake-game')->with('success','Created Successful');
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function Delete(FakeGame $fakeGame)
    {
        try
        {

            $fakeGame->delete();

            return redirect('/fake-game')->with('success','Deleted Successful');

        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }
}
