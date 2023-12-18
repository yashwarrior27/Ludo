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
                    <form class="validate-form" method="post">
                        @csrf
                        <div class="row">

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">User Name</label>
                                <input type="text" class="form-control" disabled value="{{$result->username??''}}" >
                              </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile No.</label>
                                <input type="text" class="form-control" disabled value="{{$result->mobile??''}}" >
                              </div>
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
