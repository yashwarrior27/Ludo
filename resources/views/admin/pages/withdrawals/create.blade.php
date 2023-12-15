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
                    <form class="validate-form"  method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Mobile No.</label>
                              <input type="text" class="form-control" disabled value="{{$withdrawal?->User?->mobile??'-'}}">
                          </div>
                           <div class="mb-3">
                            <label for="" class="form-label">UPI ID</label>
                              <input type="text" class="form-control" disabled value="{{$withdrawal?->User?->UserDetail?->upi_id??'-'}}">
                          </div>
                          <div class="mb-3">
                              <label for="" class="form-label">Amount</label>
                              <input type="text" class="form-control" disabled value="{{$withdrawal?->amount??'-'}}">
                          </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select class="form-select" name="status" required id="status" >
                                <option value="">Select Status</option>
                                <option value="success" {{$withdrawal->status=='success'?'selected':''}}>Success</option>
                                <option value="rejected" {{$withdrawal->status=='rejected'?'selected':''}}>Rejected</option>
                            </select>
                            @error('status')
                             <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Transaction Id</label>
                            <input type="text" class="form-control" name="transaction_id" id="transaction_id" required disabled placeholder="Transaction ID">
                            @error('transaction_id')
                            <span class="text-danger">{{$message}}</span>
                           @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Comment</label>
                          <textarea class="form-control" name="comment"  placeholder="Comment" rows="2"></textarea>
                          @error('comment')
                          <span class="text-danger">{{$message}}</span>
                         @enderror
                        </div>
                          <button class="btn btn-success btn-sm" type="submit" >Submit</button>
                      </form>
             </div>
            </div>
        </div>
       </div>
</div>

@endsection
@section('script')
<script>
 $('#status').on('change', function () {
      let val=$(this).val();
      if(val=='success')
      {
          $('#transaction_id').attr('disabled',false);
      }
      else
      {
        $('#transaction_id').attr('disabled',true);
      }
    });
</script>
@endsection
