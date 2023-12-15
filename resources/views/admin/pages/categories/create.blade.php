@extends('admin.layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-10 ">
        <div class="card border-bottom border-primary">
           <div class="card-body p-0 p-3">
               <div class="row">
                   <div class="col-10">
                       <h3 class="m-0">{{$title ?? 'title'}}</h3>
                   </div>
               </div>
           </div>
        </div>
       </div>
       <div class="col-12 mt-5">
        <div class="card border-bottom border-primary">
            <div class="card-body">
                <div class="row">
                    <form action="{{url('/category-create')}}" class="validate-form"  method="post" enctype="multipart/form-data">
                        @csrf
                      @if (isset($data))
                          <input type="hidden" name="id" value="{{$data->id}}">
                      @endif
                        <div class=" col-12 mb-3">
                            <label for="" class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{isset($data)?$data?->name:''}}" required >
                              @error('name')
                                  <span>
                                    {{$message}}
                                  </span>
                              @enderror
                          </div>
                        <div class="row">
                          <div class="col-6 mb-3">
                            <label for="" class="form-label">Image</label>
                              <input type="file" class="form-control" name="image"  accept="image/*" {{!isset($data)?'required':''}}>
                              @error('image')
                                  <span>
                                    {{$message}}
                                  </span>
                              @enderror
                          </div>

                          @if (isset($data))

                          <div class="col-6 mb-3 text-center">
                               <img src="{{url("/assets/images/{$data->image}")}}" class="img-fluid w-50" alt="">
                          </div>
                          @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label for="" class="form-label">Status</label>
                            <select class="form-select" name="status" required >

                                <option value="1" {{isset($data) && $data->status=='1'?'selected':'' }} >Active</option>
                                <option value="0" {{isset($data) && $data->status=='0'?'selected':'' }}>De-Active</option>
                            </select>
                            @error('status')
                             <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <button class="btn btn-success btn-sm" type="submit" >Update</button>
                      </form>
             </div>
            </div>
        </div>
       </div>
</div>

@endsection
