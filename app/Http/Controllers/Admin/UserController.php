<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Index(Request $request)
    {
        try
        {

         $title='Users';

         $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

         $query=User::with('UserDetail','Parent');

         if(isset($request->filter))
         {
            $query->where('status',$request->filter);
         }

         if(isset($request->search) && !empty($request->search))
         {
             $query->where(function($query)use($request){
                 $query->whereHas('UserDetail',function($q)use($request){
                     $q->where('status','like',"%{$request->search}%");
               })->orWhereHas('Parent',function($q)use($request){
                $q->where('mobile','like',"%{$request->search}%");
          })->orWhere('username','like',"%{$request->search}%")->orWhere('mobile','like',"%{$request->search}%")->orWhere('created_at','like',"%{$request->search}%");
             });

         }
         $data=$query->orderBy('id','Desc')->paginate($paginate);

         return view('admin.pages.users.index',compact('data','title'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }
}
