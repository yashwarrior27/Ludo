@extends('admin.layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-10 ">
        <div class="card border-bottom {{explode(' ',$title)[1]=='Edit'?'border-warning':'border-success'}}">
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
        <div class="card border-bottom {{explode(' ',$title)[1]=='Edit'?'border-warning':'border-success'}}">
            <div class="card-body">
                <div class="row">
                    <form class="validate-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="register_id" class="form-label">Register ID</label>
                                <input type="text" class="form-control" disabled value="{{$result->register_id??''}}" >
                              </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">User Name</label>
                                <input type="text" class="form-control" disabled value="{{$result->username??''}}" >
                              </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" disabled value="{{old('email',$result->email??'')}}" >
                              </div>
                        </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input class="form-control"  type="text" id="name" name='name' placeholder="Name" required value="{{old('name',$result->name??'')}}">
                          <span class="text-danger">@error('name')
                              {{$message}}
                          @enderror</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Phone No.</label>
                            <input class="form-control"  type='text' id="number" name='number' placeholder="Phone" required value="{{old('number',$result->number??'')}}" minlength="8" maxlength="12" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                            <span class="text-danger">@error('number')
                                {{$message}}
                            @enderror</span>
                          </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="male" {{isset($result) && $result->gender=="male"?'selected':''}}> Male
                                </option>
                                <option value="female" {{isset($result) && $result->gender=="female"?'selected':''}}>Female
                                </option>
                            </select>
                        </div>
                    </div>
                    </div>

                          <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                               <label for="profile_image" class="form-label">Profile Image</label>
                               <input class="form-control"  type="file" id="profile_image" name='image' placeholder="Profile Image"  accept='image/*'>
                               <span class="text-danger">@error('image')
                                   {{$message}}
                               @enderror</span>
                             </div>
                           </div>
                           <div class="col-6 ">
                            @if (isset($result) && !empty($result->image))

                            <img src="{{asset("assets/dashboard/img/profile_images/{$result?->image}")}}" style="max-width: 50%"  class="rounded" alt="">
                            @endif
                           </div>

                          </div>
                          <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{isset($result) && $result->status=="1"?'selected':''}}> Active
                                </option>
                                <option value="0" {{isset($result) && $result->status=="0"?'selected':''}}>De-Active
                                </option>
                            </select>
                        </div>

                        <div class="mt-4">

                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                        </div>
                      </form>
             </div>
            </div>
        </div>
       </div>
</div>
@endsection
