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

                    <form  class="validate-form"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <div class=" col-6 mb-3">
                            <label for="" class="form-label">Created User</label>
                              <input type="text" class="form-control" name="created_user" placeholder="Enter Name" minlength="4" required >
                              @error('created_user')
                                  <span>
                                    {{$message}}
                                  </span>
                              @enderror
                          </div>
                          <div class=" col-6 mb-3">
                            <label for="" class="form-label">Accepted User</label>
                              <input type="text" class="form-control" name="accepted_user" placeholder="Enter Name" minlength="4" required >
                              @error('accepted_user')
                                  <span>
                                    {{$message}}
                                  </span>
                              @enderror
                          </div>
                          <div class=" col-6 mb-3">
                            <label for="" class="form-label">Amount</label>
                              <input type="text" class="form-control" name="amount" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'" placeholder="Enter Amount" required >
                              @error('amount')
                                  <span>
                                    {{$message}}
                                  </span>
                              @enderror
                          </div>
                          <div class="col-6 mb-3">
                            <label for="" class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <option value="">Select Category</option>
                                 @foreach ($category as $key=>$value)
                                 <option value="{{$value?->id??'-'}}">{{$value?->name??'-'}}</option>
                                 @endforeach
                              </select>
                              @error('category')
                              <span>
                                {{$message}}
                              </span>
                          @enderror
                          </div>

                          <div class="col-6 mb-3" >

                              <button class="btn btn-success btn-sm" type="submit" >Update</button>
                          </div>
                        </div>
                    </form>
            </div>
        </div>
       </div>
</div>

@endsection
