<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function Index(Request $request)
  {
    try
    {  $title='Categories';

        $paginate= isset($request->paginate) && !empty($request->paginate)?$request->paginate:10;

        $query=Category::query();

        if(isset($request->filter))
        {
           $query->where('status',$request->filter);
        }

        if(isset($request->search) && !empty($request->search))
        {
            $query->where(function($query)use($request){
                $query->where('name','like',"%{$request->search}%");
            });

        }
        $data=$query->paginate($paginate);

        return view('admin.pages.categories.index',compact('data','title'));

    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }
  }

  public function CategoryCreate()
  {
    try
    {
        $title='Game Create';
        return view('admin.pages.categories.create',compact('title'));

    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }
  }

  public function CategoryStore(Request $request)
  {
    $req=[
        'name'=>'required|string',
        'status'=>'required|in:1,0'
    ];

    if(isset($request->id) && !empty($request->id))
        $req['image']='nullable|image|max:5000';
    else
       $req['image']='required|image|max:5000';

    $request->validate($req);
    try
    {
      if(isset($request->image) && !empty($request->image))
      $image=$this->uploadDocuments($request->image,public_path('/assets/images/'));

      $data=['name'=>$request->name,'status'=>$request->status];

      if(isset($image))
      $data['image']=$image;

      Category::updateOrCreate(['id'=>$request->id],$data);

      return redirect('/categories')->with('success','Create successful');
    }
    catch(\Exception $e)
    {
        return $this->ErrorMessage($e);
    }

  }

  public function CategoryEdit(Category $category)
  {
    try
    {
        $title='Category Edit';
        $data=$category;
        return view('admin.pages.categories.create',compact('title','data'));
    }
    catch(\Exception $e)
    {
    return $this->ErrorMessage($e);
    }
  }
}
