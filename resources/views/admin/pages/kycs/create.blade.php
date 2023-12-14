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
                   <div class="col-2" style="align-self: center">
                       <h5 class="m-0">{{$userDetail->User?->register_id??'-'}}</h5>
                   </div>
               </div>
           </div>
        </div>
       </div>
       <div class="col-12 mt-5">
        <div class="card border-bottom {{explode(' ',$title)[1]=='Edit'?'border-warning':'border-success'}}">
            <div class="card-body">
                    <form class="validate-form"  method="post">
                        @csrf
            @if ($userDetail->kycname_status=='2')
               <input type="hidden" name="kycname_status" value="{{$userDetail->kycname_status}}" >
            @endif
            @if ($userDetail->pan_status=='2')
               <input type="hidden" name="pan_status" value="{{$userDetail->pan_status}}" >
            @endif
            @if ($userDetail->aadhar_status=='2')
               <input type="hidden" name="aadhar_status" value="{{$userDetail->aadhar_status}}" >
            @endif
                     <div class="row justify-content-center">
                         <div class="col-5">
                            <label class="form-label">KYC Name</label>
                            <input type="text" class="form-control" value="{{$userDetail?->kyc_name??'-'}}" disabled>
                         </div>
                         <div class="col-5">
                             <label class="form-label">KYC Name Status</label>
                             <select class="form-select" name="kycname_status" required {{$userDetail?->kycname_status=='2'?'disabled':''}}>
                                 <option value="">Select Status</option>
                                 <option value="0" {{$userDetail?->kycname_status=='0'?'selected':''}}>Rejected</option>
                                 <option value="2" {{$userDetail?->kycname_status=='2'?'selected':''}}>Verified</option>
                             </select>
                             @error('kycname_status')
                                <span class="text-danger">{{$message}}</span>
                             @enderror
                         </div>
                     </div>

                     <div class="row justify-content-center mt-4">
                        <div class="col-4">
                           <label class="form-label">Pan Number</label>
                           <input type="text" class="form-control" value="{{$userDetail?->pan_number??'-'}}" disabled>
                        </div>
                        <div class="col-4 text-center">
                            <label class="form-label d-block">Pan Card Image</label>
                            <a href="{{url("assets/dashboard/img/pan_images/$userDetail->pan_image")}}" download><img src="{{url("assets/dashboard/img/pan_images/$userDetail->pan_image")}}" class="rounded img-fluid w-50" alt=""></a>
                         </div>
                        <div class="col-4">
                            <label class="form-label">Pan Card Status</label>
                            <select class="form-select" name="pan_status" required {{$userDetail?->pan_status=='2'?'disabled':''}} >
                                <option value="">Select Status</option>
                                <option value="0" {{$userDetail?->pan_status=='0'?'selected':''}}>Rejected</option>
                                <option value="2" {{$userDetail?->pan_status=='2'?'selected':''}}>Verified</option>
                            </select>
                            @error('pan_status')
                            <span class="text-danger">{{$message}}</span>
                         @enderror
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-4">
                           <label class="form-label">Aadhar Number</label>
                           <input type="text" class="form-control" value="{{$userDetail?->aadhaar_number??'-'}}" disabled>
                        </div>
                        <div class="col-4 text-center">
                            <label class="form-label d-block">Aadhar Card Front Image</label>
                            <a href="{{url("assets/dashboard/img/aadhar_images/$userDetail->aadhaar_front_image")}}" download><img src="{{url("assets/dashboard/img/aadhar_images/$userDetail->aadhaar_front_image")}}" class="rounded img-fluid w-50" alt=""></a>
                         </div>
                         <div class="col-4 text-center">
                            <label class="form-label d-block">Aadhar Card Back Image</label>
                            <a href="{{url("assets/dashboard/img/aadhar_images/$userDetail->aadhaar_back_image")}}" download><img src="{{url("assets/dashboard/img/aadhar_images/$userDetail->aadhaar_back_image")}}" class="rounded img-fluid w-50" alt=""></a>
                         </div>

                         <div class="col-5 mt-3" >
                            <label class="form-label">Aadhar Card Status</label>
                            <select class="form-select" name="aadhar_status" required {{$userDetail?->aadhar_status=='2'?'disabled':''}} >
                                <option value="">Select Status</option>
                                <option value="0" {{$userDetail?->aadhar_status=='0'?'selected':''}}>Rejected</option>
                                <option value="2" {{$userDetail?->aadhar_status=='2'?'selected':''}}>Verified</option>
                            </select>
                            @error('aadhar_status')
                            <span class="text-danger">{{$message}}</span>
                         @enderror
                        </div>

                        <div class="col-5 mt-3 text-center" style="align-self: end">
                            <button type="submit" class="btn btn-success" {{$userDetail?->status==1?'disabled':''}}>Update</button>
                        </div>

                    </div>


                      </form>
            </div>
        </div>
       </div>
</div>

@endsection

