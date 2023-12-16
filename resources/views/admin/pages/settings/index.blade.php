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
           <form class="validate-form" method="POST" enctype="multipart/form-data">
               @csrf
               @if (isset($data['qr_code']) && !empty($data['qr_code']))
                   <input type="hidden" name="qr_code_d" value="{{$data['qr_code']}}" id="">
               @endif
               <div class="row">

                <div class="col-6 mb-3">
                    <label for="upi_id" class="form-label">UPI ID</label>
                    <input type="text" class="form-control" value="{{$data['upi_id']??''}}" name="upi_id" required>
                    @error('upi_id')
                     <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>

                  <div class="col-6 mb-3">
                    <label for="upi_id" class="form-label">Telegram</label>
                    <input type="text" class="form-control" value="{{$data['telegram']??''}}" name="telegram" required>
                    @error('telegram')
                    <span class="text-danger">{{$message}}</span>
                   @enderror
                  </div>
                  <div class="col-6 mb-3">
                    <label for="upi_id" class="form-label">Whatsapp</label>
                    <input type="text" class="form-control" value="{{$data['whatsapp']??''}}" name="whatsapp" required>
                    @error('whatsapp')
                    <span class="text-danger">{{$message}}</span>
                   @enderror
                  </div>

                <div class="row">
                <div class="col-6 mb-3">
                  <label for="qr_code" class="from-label">QR Code</label>
                  <input type="file" name="qr_code" class="form-control"  accept="image/*" {{isset($data['qr_code']) && empty($data['qr_code'])?'required':''}}>
                    @error('qr_code')
                    <span class="text-danger">{{$message}}</span>
                   @enderror
                </div>

                <div class="col-6 mb-3 text-center">
                   <a href="{{url("/assets/images/{$data['qr_code']}")}}" class="text-center"><img src="{{url("/assets/images/{$data['qr_code']}")}}" class="img-fluid w-50" alt=""></a>
                </div>

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
