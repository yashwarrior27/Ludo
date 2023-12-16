<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class AssetController extends Controller
{
   public function Categories()
   {
       try
       {
           $data=Category::selectRaw("id,name,CONCAT('".url('/assets/images')."/',image) as image")->where('status',1)->get()->toArray();
           return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);
       }
       catch(\Exception $e)
       {
        return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
       }
   }

   public function Settings()
   {
    try
    {
        $data=[];
        $settings=Setting::whereIn('key',['telegram','whatsapp'])->get();

        foreach($settings as $key=>$value)
        {
            $data[$value->key]=$value->value;
        }

      return \ResponseBuilder::success($this->messages['SUCCESS'],$this->success,$data);
    }
    catch(\Exception $e)
    {
        return \ResponseBuilder::fail($this->ErrorMessage($e),$this->serverError);
    }
   }


}
