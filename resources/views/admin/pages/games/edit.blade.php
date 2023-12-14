@extends('admin.layouts.main')
@section('content')
@php
 $gamestatus=[
     '0'=>['Matching'],
     '1'=>['Game Start'],
     '2'=>['Room Code Accepted'],
     '3'=>['Status Update'],
     '4'=>['Complete'],
     '5'=>['Cancelled']
];
@endphp
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
           <form class="validate-form" method="POST">
               @csrf
               <div class="row">
            <div class="col-6 mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" value="{{$data?->Category?->name??'-'}}" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="set_user" class="form-label">Set User (Id -> <span class="text-primary"><b>{{$data?->created_id??'-'}}</b></span>)</label>
                <input type="text" class="form-control" value="{{$data?->CreatedUser?->username??'-'}}" disabled>
              </div>

              <div class="col-6 mb-3">
                <label for="accept_user" class="form-label">Accepted User (Id -> <span class="text-primary"><b>{{$data?->accepted_id??'-'}}</b></span>)</label>
                <input type="text" class="form-control" value="{{$data?->AcceptedUser?->username??'-'}}" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" value="{{$data?->amount??'-'}}" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="room_code" class="form-label">Room Code</label>
                <input type="text" class="form-control" value="{{$data?->room_code??'-'}}" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="status" class="form-label">Date & Time</label>
               <input type="datetime-local" class="form-control" value="{{date('Y-m-d H:i:s',strtotime($data?->created_at))??'-'}}" disabled>
               </div>
               <div class="col-6 mb-3">
                <label for="status" class="form-label">Game Status</label>
                <input type="text" class="form-control" value="{{ $gamestatus[$data?->status][0]??'-'}}" disabled>
              </div>





              @if ($data?->status=='4' || $data?->status=='5')

              <div class="col-6 mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" disabled>{{$data?->comment??'-'}}</textarea>
              </div>

              <div class="col-6 mb-3">
                <label for="winner" class="form-label">Winner User (Id -> <span class="text-primary"><b>{{$data?->Winner?->id??'-'}}</b></span>)</label>
                <input type="text" class="form-control" value="{{$data?->Winner->username??'-'}}" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="winner_amount" class="form-label">Winner Amount</label>
                <input type="text" class="form-control" value="{{$data?->winner_amount??'-'}}" disabled>
              </div>

              <div class="col-6 mb-3 ">
                <label for="penalty_name"  class="form-label">Penalty User name (Id -> <span class="text-primary"><b>{{$data?->Penalty?->User?->id??'-'}}</b></span>)</label>
                 <input type="text" class="form-control" value="{{$data?->Penalty?->User?->username??'-'}}" disabled>
              </div>

              <div class="col-6 mb-3 ">
                <label for="penalty_amount"  class="form-label ">Penalty Amount</label>
                <input type="text" class="form-control" value="{{$data?->Penalty?->amount??'-'}}" disabled>
              </div>

              <div class="col-6 mb-3">
                   <label for="penalty_reason"> Penalty Reason</label>
                   <textarea class="form-control" disabled>{{$data?->Penalty?->type??'-'}}</textarea>
              </div>

              @endif

              <div class="col-12 mb-3 mt-4">
                <h3>User Game Status</h3>
              </div>

              @if (count($data?->GameResult)>0)

              @foreach ($data?->GameResult as $key=> $item)
              <div class="col-12 row mb-3">
                <div class="col-3">
                 <label for="name" class="form-label">{{$key+1}}st User (Id -> <span class="text-primary"><b>{{$item?->User?->id??'-'}}</b></span>)</label>
                <input type="text" class="form-control" value="{{$item?->User?->username??'-'}}" disabled>
                </div>
                <div class="col-3">
                    <label for="status" class="form-label">Status</label>
                   <input type="text" class="form-control" value="{{$item?->status??'-'}}" disabled>
                   </div>
                   <div class="col-3">
                    <label for="status" class="form-label">Date & Time</label>
                   <input type="datetime-local" class="form-control" value="{{date('Y-m-d H:i:s',strtotime($item?->created_at))??'-'}}" disabled>
                   </div>
                   @if ($item?->status=='win')
                   <div class="col-3">
                    <label for="image" class="form-label">Image</label>
                    <div class="form-control text-center"><a href="{{url("/assets/images/win_game/{$item?->image}")}}" download><img src="{{url("/assets/images/win_game/{$item?->image}")}}" class="img-fluid w-50" alt=""></a></div>
                   </div>
                   @else
                   <div class="col-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea class="form-control" disabled>{{$item?->comment??'-'}}</textarea>
                   </div>
                   @endif
             </div>
              @endforeach
              @else
              <div class="col-6 mb-3">
                <label for="status" class="form-label">1st User</label>
                <input type="text" class="form-control" value="-" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="status" class="form-label">2nd User</label>
                <input type="text" class="form-control" value="-" disabled>
              </div>
              @endif

            @if ($data?->status=='3')
            <div class="row">
                <div class="col-7 mb-3  mt-4">

                  <input class="form-check-input" type="checkbox" id="penalty_check" onchange="if(this.checked == true) { document.getElementById('penalty_user_id').disabled = false; document.getElementById('penalty_amount').disabled = false; document.getElementById('penalty_reason').disabled = false;} else { document.getElementById('penalty_user_id').disabled = true; document.getElementById('penalty_amount').disabled = true;document.getElementById('penalty_reason').disabled = true;}">
                  <label class="form-check-label px-2" for="penalty_check">
                      <h4>Penalty Check</h4>
                  </label>

             </div>


             <div class="col-6 mb-3 ">
              <label for="penalty_user_id"  class="form-label">Penalty User Id</label>
               <input type="text" class="form-control" name="penalty_user_id" placeholder="Enter  User Id" id="penalty_user_id"  onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'" required disabled>
               @error('penalty_user_id')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="col-6 mb-3 ">
              <label for="penalty_amount"  class="form-label ">Penalty Amount</label>
               <input type="text" class="form-control" name="penalty_amount" placeholder="Enter Amount" id="penalty_amount" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'" required disabled>
               @error('penalty_amount')
               <span class="text-danger">{{$message}}</span>
               @enderror
            </div>

            <div class="col-6 mb-3">
                 <label for="penalty_reason"> Penalty Reason</label>
                 <textarea class="form-control" name="penalty_reason" placeholder="Enter Penalty Reason" id="penalty_reason" disabled></textarea>
                 @error('penalty_reason')
                     <span class="text-danger">{{$message}}</span>
                 @enderror
            </div>
          </div>
            @endif

              @if ($data?->status!='4' && $data?->status!='5')

              <div class="col-6 mb-3 mt-4">
                <label for="status"  class="form-label">Final Status</label>
                <select class="form-select" name="status" required onchange="if(this.value === '4') { document.getElementById('winner_user_id').disabled = false; } else { document.getElementById('winner_user_id').disabled = true; }">
                    <option value="" >Select Status</option>
                   @if ($data?->status=='3')
                   <option value="4">Complete</option>
                   @endif
                    <option value="5">Cancelled</option>
                  </select>
                  @error('status')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
              </div>
              @if ($data?->status=='3')
              <div class="col-6 mb-3 mt-4">
                <label for="winner_user_id"  class="form-label">Winner User Id</label>
                 <input type="text" class="form-control" name="winner_user_id" placeholder="Enter Winner Id" id="winner_user_id" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'" required disabled>
                 @error('winner_user_id')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
              </div>
               @endif

              <div class="col-6 mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" placeholder="Enter Comment" name="comment"></textarea>
                @error('comment')
                <span class="text-danger">{{$message}}</span>
                @enderror
               </div>

              <div class=" col-7 mb-3 mt-4">
                <button class="btn btn-success" type="submit">Update</button>
               </div>
              @endif
            </div>
           </form>
        </div>
    </div>
</div>
</div>
@endsection
