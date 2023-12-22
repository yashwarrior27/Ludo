@extends('admin.layouts.main')
@section('content')

@php
    $user=Auth::user();
@endphp
    <div class="row justify-content-center">
      <div class="col-lg-6 mb-5 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Hello {{$user->name}}! 🎉</h5>
                <p class="mb-4">
                 Welcome to the {{config('app.name')}}
                </p>

              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="{{url('admin_assets/assets/img/illustrations/man-with-laptop-light.png')}}"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      @if ($user->id==1||$user->id==2|| $user->id==6)
       <div class="col-lg-3 mb-4 ">
                  <div class="card p-3 text-center">
                     <h4>Total Earn</h4>
                     <h4 class="text-primary">{{number_format($data['total_earn'],2)??'0'}}</h4>
                    </div>
      </div>
      <div class="col-lg-3 mb-4 ">
                  <div class="card p-3 text-center">
                     <h4>Total Deposits</h4>
                     <h4 class="text-primary">{{number_format($data['total_deposits'],2)??'0'}}</h4>
                    </div>
      </div>
      <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Total Withdrawals</h4>
           <h4 class="text-primary">{{number_format($data['total_withdrawals'],2)??'0'}}</h4>
          </div>
       </div>
       <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Total Win Amount</h4>
           <h4 class="text-primary">{{number_format($data['total_win'],2)??'0'}}</h4>
          </div>
       </div>
          <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Total Referral Amount</h4>
           <h4 class="text-primary">{{number_format($data['total_referral'],2)??'0'}}</h4>
          </div>
       </div>
       
       <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Total Users</h4>
           <h4 class="text-primary">{{$data['total_user']??'0'}}</h4>
          </div>
       </div>
       <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Today's Deposit</h4>
           <h4 class="text-primary">{{number_format($data['today_deposit'],2)??'0'}}</h4>
          </div>
       </div>
       <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Today's Withdrawal</h4>
           <h4 class="text-primary">{{number_format($data['today_withdrawal'],2)??'0'}}</h4>
          </div>
       </div>
       <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Today's Win Amount</h4>
           <h4 class="text-primary">{{number_format($data['today_win'],2)??'0'}}</h4>
          </div>
       </div>
       <div class="col-lg-3 mb-4 ">
        <div class="card p-3 text-center">
           <h4>Today's User</h4>
           <h4 class="text-primary">{{$data['today_user']??'0'}}</h4>
          </div>
       </div>
      @endif
      @if ($user->id==1 || $user->id==6)
      <div class="col-9 mt-3 card p-4">
        <form  class="validate-form" method="POST">

            @csrf
            <div class="row">

       <div class="mb-3 col-12">
           <label class="form-label">Roles</label>
        <select class="form-select" name="role" required>
            <option value="">Select Role</option>
            <option value="1">Super Admin</option>
            <option value="2">Admin</option>
            <option value="3">Manger</option>
            <option value="4">Supervisor D</option>
            <option value="5">Supervisor W</option>
          </select>
          @error('role')
                 <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="mb-3 col-6">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter Password" minlength="8" required>
            @error('password')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="mb-3 col-6">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Enter Password" minlength="8" required>
            @error('confirm_password')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="mb-3 col-6">
               <button class="btn btn-success" type="submit">Update</button>
        </div>
        </div>
        </form>
      </div>
      @endif
    </div>
@endsection
