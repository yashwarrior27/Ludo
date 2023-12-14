@extends('admin.layouts.main')
@section('content')

<div class="row justify-content-center">

<div class="col-10 ">
 <div class="card border-bottom border-info">
    <div class="card-body p-0 p-3">
        <div class="row">
            <div class="col-10">

                      <img src="{{asset("assets/dashboard/img/profile_images/{$user?->image}")}}" alt="" style="max-width: 10%;
                      border-radius: 50%;">

                <h5 class="m-0 d-inline-block px-3">{{$user?->register_id}}</h5>
            </div>
            <div class="col-2" style="align-self: center;">
                <a href="{{url("/admin/user-edit/{$user?->id}")}}" class="btn btn-warning py-1 px-3">Edit</a>
            </div>
        </div>
    </div>
 </div>
</div>

<div class="col-12 mt-5">
    <div class="card border-bottom border-info">
        <div class="card-body">
            <div class="row">
                <div class="col-3 p-2">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{$user?->name??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">User Name</label>
                    <input type="text" class="form-control" value="{{$user?->username??'-'}}" disabled>
                </div>

                <div class="col-3 p-2">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{$user?->email??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">

                    <label class="form-label">Phone No.</label>
                    <input type="text" class="form-control" value="{{$user?->number??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">Register ID</label>
                    <input type="text" class="form-control" value="{{$user?->register_id??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">Register ID</label>
                    <input type="text" class="form-control" value="{{$user?->Parent?->register_id??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">Gender</label>
                    <input type="text" class="form-control" value="{{$user?->gender??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">Country Code</label>
                    <input type="text" class="form-control" value="{{'+ '.$user?->countrycode?->phonecode." ({$user?->countrycode?->name})"??'-'}}" disabled>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 mt-5">
    <div class="card border-bottom border-info">
        <div class="card-body">
            <div class="row">
                <div class="col-10 my-2 ">
                    <h4 class="d-inline-block">KYC Details</h4>
                    @if (isset($userDetails) && !empty($userDetails))
                        <a href="{{url("/admin/user-kyc-edit/{$userDetails->id}")}}" class="btn btn-warning btn-sm px-2 mx-2">KYC Edit</a>
                    @endif
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">KYC Name</label>
                    <input type="text" class="form-control" value="{{$userDetails?->kyc_name??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">PAN Number</label>
                    <input type="text" class="form-control" value="{{$userDetails?->pan_number??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">Aadhar Number</label>
                    <input type="text" class="form-control" value="{{$userDetails?->aadhaar_number??'-'}}" disabled>
                </div>
                <div class="col-3 p-2">
                    <label class="form-label">Status</label>
                    <input type="text" class="form-control" value="{{$userDetails?->status==1?'Complete':'Pending'??'-'}}" disabled>
                </div>

                <div class="col-4 p-2 text-center mt-1">
                    <label class="form-label d-block py-2">PAN Card Image</label>
                    <a href="{{url("assets/dashboard/img/pan_images/$userDetails?->pan_image")}}" download><img src="{{url("assets/dashboard/img/pan_images/$userDetails?->pan_image")}}" alt=" pan card" class='w-50 rounded'></a>
                </div>
                <div class="col-4 p-2 text-center mt-1">
                    <label class="form-label d-block py-2">Aadhar Card Front Image</label>
                    <a href="{{url("assets/dashboard/img/aadhar_images/$userDetails?->aadhaar_front_image")}}" download><img src="{{url("assets/dashboard/img/pan_images/$userDetails?->pan_image")}}" alt=" aadhar card front" class='w-50 rounded'></a>
                </div>
                <div class="col-4 p-2 text-center mt-1">
                    <label class="form-label d-block py-2">Aadhar Card Back Image</label>
                    <a href="{{url("assets/dashboard/img/pan_images/$userDetails?->pan_image")}}" download><img src="{{url("assets/dashboard/img/aadhar_images/$userDetails?->aadhaar_back_image")}}" alt=" aadhar card back" class='w-50 rounded'></a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="col-12 mt-5">
    <div class="card border-bottom border-info">
        <div class="card-body">
            <h4>User Coins</h4>
            <table class="table table-striped  table-hover table-borderless pt-3 " id="myTable">
                <thead class="">
                  <tr>
                    <th scope="col" class="text-center">Sr No.</th>
                    <th scope="col" class="text-center">Coins</th>
                    <th scope="col" class="text-center">Lock-In Days</th>
                    <th scope="col" class="text-center">Remaining Days</th>
                    <th scope="col" class="text-center">Release Status</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                 @if (isset($userCoins) && count($userCoins)>0)
                     @foreach ($userCoins as $key=>$item)
                     <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item?->coins??'-'}}</td>
                        <td class="text-center">{{$item?->lockin_days??'-'}}</td>
                        <td class="text-center">{{$item?->lockin_days-$item?->days_count??'-'}}</td>
                        <td class="text-center">
                            @if ($item?->withdrawal_status==0)
                               <span class="badge bg-danger">Locked</span>
                               @else
                               <span class="badge bg-success">Released</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="if (confirm('Are you sure you want to proceed?')) { window.location.href = '{{url("/admin/coin-released/{$item->id}")}}'; }" {{$item?->withdrawal_status==1?'disabled':''}}>Release</button>
                        </td>
                    </tr>
                     @endforeach
                 @endif
                </tbody>
              </table>
        </div>
    </div>
</div>
<div class="col-12 mt-5">
    <div class="card border-bottom border-info">
        <div class="card-body">
            <h4>Coin Withdrawals</h4>
            <table class="table table-striped  table-hover table-borderless pt-3 " id="myTable2">
                <thead class="">
                  <tr>
                    <th scope="col" class="text-center">Sr No.</th>
                     <th scope="col" class="text-center">Coins</th>
                    <th scope="col" class="text-center">Wallet Address</th>
                    <th scope="col" class="text-center">Transaction Id</th>
                    <th scope="col" class="text-center">Comment</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                 @if (isset($coinwithdrawals) && count($coinwithdrawals)>0)
                     @foreach ($coinwithdrawals as $key=>$item)
                     <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item->coin_quantity??'-'}}</td>
                        <td class="text-center">{{$item->wallet_address??'-'}}</td>
                        <td class="text-center">{{$item?->transaction_id??'-'}}</td>
                        <td class="text-center">{{$item?->comment??'-'}}</td>
                           <td class="text-center">
                               @if ($item?->status=='pending')
                                <span class="badge bg-warning">Pending</span>
                                @elseif ($item?->status=='success')
                                <span class="badge bg-success">Success</span>
                                @else
                                <span class="badge bg-danger" >Rejected</span>
                               @endif
                           </td>

                        <td>
                           <a href="{{url("/admin/withdrawal-edit/{$item->id}")}}" class="btn btn-sm btn-warning" style="{{$item->status!='pending'?'pointer-events:none;opacity:.6;':''}}" >Edit</a>
                        </td>
                    </tr>
                     @endforeach
                 @endif
                </tbody>
              </table>
        </div>
    </div>
</div>
<div class="col-12 mt-5">
    <div class="card border-bottom border-info">
        <div class="card-body">
            <h4>USD Withdrawals</h4>
            <table class="table table-striped  table-hover table-borderless pt-3 " id="myTable3">
                <thead class="">
                  <tr>
                    <th scope="col" class="text-center">Sr No.</th>
                     <th scope="col" class="text-center">USD</th>
                    <th scope="col" class="text-center">Wallet Address</th>
                    <th scope="col" class="text-center">Transaction Id</th>
                    <th scope="col" class="text-center">Comment</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                 @if (isset($usdwithdrawals) && count($usdwithdrawals)>0)
                     @foreach ($usdwithdrawals as $key=>$item)
                     <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item->amount??'-'}}</td>
                        <td class="text-center">{{$item->wallet_address??'-'}}</td>
                        <td class="text-center">{{$item?->transaction_id??'-'}}</td>
                        <td class="text-center">{{$item?->comment??'-'}}</td>
                           <td class="text-center">
                               @if ($item?->status=='pending')
                                <span class="badge bg-warning">Pending</span>
                                @elseif ($item?->status=='success')
                                <span class="badge bg-success">Success</span>
                                @else
                                <span class="badge bg-danger" >Rejected</span>
                               @endif
                           </td>

                        <td>
                           <a href="{{url("/admin/usd-withdrawal-edit/{$item->id}")}}" class="btn btn-sm btn-warning" style="{{$item->status!='pending'?'pointer-events:none;opacity:.6;':''}}" >Edit</a>
                        </td>
                    </tr>
                     @endforeach
                 @endif
                </tbody>
              </table>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
    <script>
         $('#myTable2').DataTable();
         $('#myTable3').DataTable();
    </script>
@endsection
