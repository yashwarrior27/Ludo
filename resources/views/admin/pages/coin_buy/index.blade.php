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
<div class="col-8 mt-5">
    <div class="card border-bottom border-primary">
        <div class="card-body">
           <form class="validate-form" method="POST">
               @csrf
            <div class="mb-3">
                <label for="register_id" class="form-label">Register ID</label>
                <input type="text" class="form-control" name="register_id" required placeholder="Enter Register ID">
                @error('register_id')
                <span class="text-danger">{{$message}}</span>
               @enderror
              </div>
              <div class="mb-3">
                <label for="coins" class="form-label">Coins</label>
                <input type="text" class="form-control"  name="coins" required onkeydown="javascript: return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.code) || (event.key === '.' && event.target.value.indexOf('.') === -1) || (!isNaN(Number(event.key)) && event.code !== 'Space')" placeholder="Enter Coins">
                @error('coins')
                <span class="text-danger">{{$message}}</span>
               @enderror
              </div>
                <button class="btn btn-primary" type="submit">Buy</button>
           </form>
        </div>
    </div>
</div>
</div>
@endsection
