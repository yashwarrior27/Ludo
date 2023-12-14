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
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" value="{{$data?->name??'-'}}" disabled>
              </div>
              <div class="mb-3">
                <label for="lockin" class="form-label">Lock In Days</label>
                <input type="text" class="form-control" value="{{$data?->lockin_days??'0'}}" name="lockin" required onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                @error('lockin')
                 <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" value="{{$data?->price??'0'}}" name="price" required onkeydown="javascript: return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.code) || (event.key === '.' && event.target.value.indexOf('.') === -1) || (!isNaN(Number(event.key)) && event.code !== 'Space')">
                @error('price')
                <span class="text-danger">{{$message}}</span>
               @enderror
              </div>


              <div class="mb-3 pt-2">
                   <button class="btn btn-success" type="submit">Update</button>
              </div>
           </form>
        </div>
    </div>
</div>
</div>
@endsection
