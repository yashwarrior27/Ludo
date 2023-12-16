<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function Index()
    {
        try
        { $title='Settings';
            $data =[];
          $settings=Setting::get();
          foreach($settings as $key=>$value)
          {
            $data[$value->key]=$value->value;
          }

          return view('admin.pages.settings.index',compact('title','data'));
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }

    public function Update(Request $request)
    {
        $request->validate([
            'upi_id'=>'required',
            'telegram'=>'required',
            'whatsapp'=>'required',
            'qr_code'=>'nullable|image|max:5000'
         ]);

        try
        {
            if(isset($request->qr_code) && !empty($request->qr_code))
             $image=$this->uploadDocuments($request->qr_code,public_path('/assets/images/'));
            else
            $image=$request->qr_code_d;

            Setting::query()->delete();

            $data=[
                ['key'=>'upi_id','value'=>$request->upi_id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                ['key'=>'telegram','value'=>$request->telegram,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                ['key'=>'whatsapp','value'=>$request->whatsapp,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                ['key'=>'qr_code','value'=>$image,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
        ];

         Setting::insert($data);

         return redirect('/settings')->with('success','Update Successful');
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }
}
