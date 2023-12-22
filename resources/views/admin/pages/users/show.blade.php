@extends('admin.layouts.main')
@section('content')
@php
 $gamestatus=[
     '0'=>['Matching','warning'],
     '1'=>['Game Start','primary'],
     '2'=>['Room Code Accepted','info'],
     '3'=>['Status Update','secondary'],
     '4'=>['Complete','success'],
     '5'=>['Cancelled','danger']
];
@endphp
<div class="row justify-content-center">

<div class="col-10 ">
 <div class="card border-bottom border-info">
    <div class="card-body p-0 p-3">
        <div class="row">
            <div class="col-5">
                <h3 class="m-0 d-inline-block mx-2">User View</h3>
                @if ($user->status=='1')
                <span class="badge bg-success">Active</span>

               @else
                <span class="badge bg-danger">De-Active</span>
               @endif
            </div>
            <div class="col-5" style="align-self: center;">
                Wallet Balance :- <span class='bg-light text-dark'>{{$user->TotalBalance()}}</span> 
            </div>    
            <div class="col-2" style="align-self: center;">
                <a href="{{url("/user-edit/{$user?->id}")}}" class="btn btn-warning py-1 px-3">Edit</a>
            </div>
        </div>
    </div>
 </div>
</div>

<div class="col-12 mt-5">
    <div class="card border-bottom border-info">
        <div class="card-body">
            <div class="row justify-content-center">

                <div class="col-5 p-2">
                    <label class="form-label">User Name</label>
                    <input type="text" class="form-control" value="{{$user?->username??'-'}}" disabled>
                </div>

                <div class="col-5 p-2">
                    <label class="form-label">Mobile No.</label>
                    <input type="text" class="form-control" value="{{$user?->mobile??'-'}}" disabled>
                </div>
                <div class="col-5 p-2">
                    <label class="form-label">Register ID</label>
                    <input type="text" class="form-control" value="{{$user?->register_id??'-'}}" disabled>
                </div>
                <div class="col-5 p-2">
                    <label class="form-label">Parent Mobile No.</label>
                    <input type="text" class="form-control" value="{{$user?->Parent?->mobile??'-'}}" disabled>
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
                         @if ($userDetails->status=='review')
                         <a href="{{url("/kyc-edit/{$userDetails->id}")}}" class="btn btn-primary btn-sm px-2 mx-2">KYC Edit</a>
                         @elseif ($userDetails->status=='pending')
                           <button class="btn btn-warning btn-sm px-2 mx-2" disabled>Pending</button>
                         @else
                           <button class="btn btn-success btn-sm px-2 mx-2" disabled>Completed</button>
                         @endif
                    @endif
                </div>

                <div class="col-4 p-2">
                    <label class="form-label">UPI ID</label>
                    <input type="text" class="form-control" value="{{$userDetails?->upi_id??'-'}}" disabled>
                </div>


                <div class="col-4 p-2 text-center mt-1">
                    <label class="form-label d-block py-2">Aadhar Card Front Image</label>
                    <a href="{{url("assets/images/aadhar/$userDetails?->aadhar_front")}}" download><img src="{{url("assets/images/aadhar/$userDetails?->aadhar_front")}}" alt=" aadhar card front" class='w-50 rounded'></a>
                </div>
                <div class="col-4 p-2 text-center mt-1">
                    <label class="form-label d-block py-2">Aadhar Card Back Image</label>
                    <a href="{{url("assets/images/aadhar/$userDetails?->aadhar_back")}}" download><img src="{{url("assets/images/aadhar/$userDetails?->aadhar_back")}}" alt=" aadhar card back" class='w-50 rounded'></a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="col-12 mt-5">
    <div class="card border-bottom border-info">
        <div class="card-body">
            <h4>User Deposit</h4>
            <table class="table table-striped  table-hover table-borderless pt-3 " id="myTable">
                <thead class="">
                  <tr>
                    <th scope="col" class="text-center">Sr No.</th>
                    <th scope="col" class="text-center">Mobile No.</th>
                    <th scope="col" class="text-center">Asked Amount</th>
                    <th scope="col" class="text-center">Approved Amount</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Date</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @if (isset($deposits) && count($deposits)>0)
                    @foreach ($deposits as $key => $item)
                    <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item?->User?->mobile??'-'}}</td>
                        <td class="text-center">{{$item?->user_amount??'-'}}</td>
                        <td class="text-center">{{$item?->amount??'-'}}</td>
                        <td class="text-center">@if ($item?->status=='pending')
                            <span class="badge bg-warning">Pending</span>
                            @elseif($item?->status=='success')
                             <span class="badge bg-success">Success</span>
                             @else
                             <span class="badge bg-danger">Rejected</span>
                        @endif</td>
                        <td class="text-center">{{date('d-m-Y',strtotime($item->created_at)??'-')}}</td>
                        <td class="text-center w-25">
                            @if ($item->status=='pending')
                            @if (Auth::user()->id!=3)
                            <a href="{{url("/deposit-edit",$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                            @endif
                             @else
                             <a href="{{url("/assets/images/deposits/{$item?->image}")}}" download ><img src="{{url("/assets/images/deposits/{$item?->image}")}}" class="img-fluid w-50" ></a>
                            @endif
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
            <h4>User Games</h4>
            <table class="table table-striped  table-hover table-borderless pt-3 " id="myTable2">
                <thead class="">
                    <tr>
                        <th scope="col" class="text-center">Sr No.</th>
                        <th scope="col" class="text-center">Category</th>
                        <th scope="col" class="text-center">Set User</th>
                        <th scope="col" class="text-center">Accepted User</th>
                        <th scope="col" class="text-center">Amount</th>
                        <th scope="col" class="text-center">Room Code</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Date</th>
                        <th scope="col" class="text-center">Action</th>
                      </tr>
                </thead>
                <tbody>
                    @if (isset($games) && count($games)>0)
                    @foreach ($games as $key => $item)
                    <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item?->Category?->name??'-'}}</td>
                        <td class="text-center">{{$item?->CreatedUser?->username??'-'}}</td>
                        <td class="text-center">{{$item?->AcceptedUser?->username??'-'}}</td>
                        <td class="text-center">{{$item?->amount??'-'}}</td>
                        <td class="text-center">{{$item?->room_code??'-'}}</td>
                        <td class="text-center"><span class="badge bg-{{$gamestatus[$item?->status][1]}}">{{$gamestatus[$item?->status][0]??'-'}}</span></td>
                        <td class="text-center">{{date('d-m-Y',strtotime($item?->created_at))??'-'}}</td>
                        <td>
                            @if ($item?->status=='0')
                            <button onclick="if(confirm('Do you want to delete?'))window.location.href='{{url("/game-delete/{$item?->id}")}}'" class="btn btn-sm btn-danger" >Delete</button>
                            @elseif($item?->status=='4' || $item?->status=='5' )
                            <a href="{{url("/game-detail/{$item?->id}")}}" class="btn btn-sm btn-warning" >View</a>
                            @else
                             <a href="{{url("/game-detail/{$item?->id}")}}" class="btn btn-sm btn-success">Edit</a>
                            @endif

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
            <h4>User Withdrawals</h4>
            <table class="table table-striped  table-hover table-borderless pt-3 " id="myTable3">
                <thead class="">
                    <tr>
                        <th scope="col" class="text-center">Sr No.</th>
                        <th scope="col" class="text-center">Mobile No.</th>
                        <th scope="col" class="text-center">UPI ID</th>
                        <th scope="col" class="text-center">Amount</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Transaction Id</th>
                        <th scope="col" class="text-center">Comment</th>
                        <th scope="col" class="text-center">Date</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                </thead>
                <tbody>
                    @if (isset($withdrawals) && count($withdrawals)>0)
                    @foreach ($withdrawals as $key => $item)
                    <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item?->User?->mobile??'-'}}</td>
                        <td class="text-center">{{$item?->upi_id??'-'}}</td>
                        <td class="text-center">{{$item?->amount??'-'}}</td>
                        <td class="text-center">
                            @if ($item?->status=='pending')
                             <span class="badge bg-warning">Pending</span>
                             @elseif ($item?->status=='success')
                             <span class="badge bg-success">Success</span>
                             @else
                             <span class="badge bg-danger" >Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">{{$item?->transaction_id??'-'}}</td>
                        <td class="text-center">{{$item?->comment??'-'}}</td>
                          <td class="text-center">{{date('d-m-Y',strtotime($item?->created_at))??'-'}}</td>
                        <td>
                            @if (Auth::user()->id!=3)
                            <a href="{{url("/withdrawal-edit/{$item->id}")}}" class="btn btn-sm btn-warning" style="{{$item?->status!='pending'?'pointer-events:none;opacity:.6;':''}}" >Edit</a>
                            @endif
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
