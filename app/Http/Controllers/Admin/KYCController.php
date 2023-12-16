<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KYCController extends Controller
{
  public function Index(Request $request)
  {
    try{
        $title='KYCs';

        $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

        $query=UserDetail::with('User');

        if(isset($request->filter))
        {
           $query->where('status',$request->filter);
        }

        if(isset($request->search) && !empty($request->search))
        {
            $query->where(function($query)use($request){
                $query->whereHas('User',function($q)use($request){
                    $q->where('mobile','like',"%{$request->search}%");
              })->where('upi_id','like',"%{$request->search}%");
            });

        }
        $data=$query->orderBy('updated_at','Desc')->paginate($paginate);

        return view('admin.pages.kycs.index',compact('data','title'));
    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }
  }

  public function KYCEdit(UserDetail $userDetail)
  {
    try
    {
        $title='KYC Edit';

       return view('admin.pages.kycs.create',compact('title','userDetail'));
    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }
  }

  public function KYCUpdate(Request $request,UserDetail $userDetail)
  {
    $request->validate([
             'status'=>'required|in:pending,success'
    ]);

    try
    {
        if($userDetail->status!='review') return redirect('/kycs')->with('error','Something went wrong.');

        if($request->status=='success')
        {
            $userDetail->status='success';
            $userDetail->save();
        }
        else
        {
            if(File::exists(public_path("/assets/images/aadhar/{$userDetail->aadhar_front}")))
               File::delete(public_path("/assets/images/aadhar/{$userDetail->aadhar_front}"));

               if(File::exists(public_path("/assets/images/aadhar/{$userDetail->aadhar_back}")))
               File::delete(public_path("/assets/images/aadhar/{$userDetail->aadhar_back}"));

               $userDetail->aadhar_front=null;
               $userDetail->aadhar_back=null;
               $userDetail->upi_id=null;
               $userDetail->status='pending';
               $userDetail->save();
        }

        return redirect('/kycs')->with('success','Update successful');

    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }
  }
}
