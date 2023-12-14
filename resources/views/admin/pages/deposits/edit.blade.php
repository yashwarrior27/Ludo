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
           <form class="validate-form" method="POST">
               @csrf
               <div class="row">
            <div class="col-6 mb-3">
                <label for="mobile" class="form-label">Mobile No.</label>
                <input type="text" class="form-control" value="{{$data?->User?->mobile??'-'}}" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="user_amount" class="form-label">Asked Amount</label>
                <input type="text" class="form-control" value="{{$data?->user_amount??'-'}}" disabled>
              </div>

              <div class="col-6 mb-3">
                <label for="amount" class="form-label">Approved Amount</label>
                <input type="text" class="form-control"  name="amount" required onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'" placeholder="Enter Amount" id="amount">
                @error('amount')
                <span class="text-danger">{{$message}}</span>
               @enderror
              </div>

              <div class="col-6 mb-3">
                <label for="status"  class="form-label">Status</label>
                <select class="form-select" name="status" required onchange="if(this.value === 'rejected') { document.getElementById('amount').disabled = true; } else { document.getElementById('amount').disabled = false; }">
                    <option value="" >Select Status</option>
                    <option value="success">Success</option>
                    <option value="rejected">Rejected</option>
                  </select>
                  @error('status')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
              </div>

              <div class="col-6 mb-3">
                  <label for="comment"  class="form-label"> Comment</label>
                  <textarea name="comment" class="form-control" placeholder="Enter Comment"></textarea>
              </div>
              <div class="col-6 mb-3 ">
                <label for="image"  class="form-label">Image</label>
                  <a class="text-center form-control" href="{{url("/assets/images/deposits/{$data?->image}")}}" download ><img src="{{url("/assets/images/deposits/{$data?->image}")}}" class="img-fluid" ></a>
              </div>

              <div class=" col-6 mb-3">
                   <button class="btn btn-success" type="submit">Update</button>
              </div>
            </div>
           </form>
        </div>
    </div>
</div>
</div>
@endsection
