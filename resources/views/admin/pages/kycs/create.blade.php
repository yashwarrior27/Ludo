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
                    <form class="validate-form"  method="post">
                        @csrf
                     <div class="row justify-content-center">
                         <div class="col-5">
                            <label class="form-label">Mobile No.</label>
                            <input type="text" class="form-control" value="{{$userDetail->User?->mobile??'-'}}" disabled>
                         </div>
                         <div class="col-5">
                             <label class="form-label">KYC Status</label>
                             <select class="form-select" name="status" required {{$userDetail?->status=='success'?'disabled':''}}>
                                 <option value="">Select Status</option>
                                 <option value="pending" {{$userDetail?->status=='pending'?'selected':''}}>Rejected</option>
                                 <option value="success" {{$userDetail?->status=='success'?'selected':''}}>Verified</option>
                             </select>
                             @error('status')
                                <span class="text-danger">{{$message}}</span>
                             @enderror
                         </div>
                     </div>
                    <div class="row justify-content-center mt-4">

                   
                        <div class="col-4 text-center">
                            <label class="form-label d-block">Aadhar Card Front Image</label>
                            <a href="{{url("/assets/images/aadhar/{$userDetail?->aadhar_front}")}}" download><img src="{{url("/assets/images/aadhar/{$userDetail?->aadhar_front}")}}" class="rounded img-fluid w-40" alt=""></a>
                         </div>
                         <div class="col-4 text-center">
                            <label class="form-label d-block">Aadhar Card Back Image</label>
                            <a href="{{url("/assets/images/aadhar/{$userDetail?->aadhar_back}")}}" download><img src="{{url("/assets/images/aadhar/{$userDetail?->aadhar_back}")}}" class="rounded img-fluid w-50" alt=""></a>
                         </div>

                        <div class="col-5 mt-5 text-center" style="align-self: end">
                            @if ($userDetail?->status=='review')
                            <button type="submit" class="btn btn-success">Update</button>
                            @endif
                        </div>
                    </div>
                      </form>
            </div>
        </div>
       </div>
</div>

@endsection

