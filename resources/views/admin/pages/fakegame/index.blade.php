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
        <div class="col-2">
            <a href="{{url('/fake-game-create')}}" class="btn btn-success ">Create</a>
        </div>
        </div>
    </div>
 </div>
</div>
<div class="col-12 mt-5">
    <div class="card border-bottom border-primary">
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped  table-hover pt-3 ">
                <div class="row">
                    <div class="col-2">
                        <form id="search-form">
                            <select name="paginate" class="form-select w-50" onchange="document.getElementById('search-form').submit()">
                                <option value="10" {{request()->query('paginate')=='10'?'selected':''}}>10</option>
                                <option value="20" {{request()->query('paginate')=='20'?'selected':''}}>20</option>
                                <option value="50" {{request()->query('paginate')=='50'?'selected':''}}>50</option>
                            </select>

                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-8">

                           <div class="row justify-content-end p-2 mb-2">

                               <div class="col-5 p-0">
                                <input type="search" class="form-control" name="search" placeholder="Search..." value="{{request()->query('search')}}">
                               </div>
                               <div class="col-3" style="align-self: center">
                                   <button class="btn btn-sm btn-info d-inline-block" type="submit">Search</button>
                                   <a href="{{ url(request()->url()) }}" class="btn btn-sm btn-danger d-inline-block" type="button" >Reset</a>
                               </div>
                           </div>

                            </div>
                        </form>
                    </div>
                </div>
                <thead>
                  <tr>
                    <th scope="col" class="text-center">Sr No.</th>
                    <th scope="col" class="text-center">Category</th>
                    <th scope="col" class="text-center">Created User</th>
                    <th scope="col" class="text-center">Accepted User</th>
                    <th scope="col" class="text-center">Amount</th>
                    <th scope="col" class="text-center">Date</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @if (isset($data) && count($data)>0)
                    @foreach ($data as $key => $item)
                    <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item?->Category?->name??'-'}}</td>
                        <td class="text-center">{{$item?->created_user??'-'}}</td>
                        <td class="text-center">{{$item?->accepted_user??'-'}}</td>
                        <td class="text-center">{{$item?->amount??'-'}}</td>
                        <td class="text-center">{{date('d-m-Y',strtotime($item?->created_at))??'-'}}</td>
                        <td>
                            <button onclick="if(confirm('Do you want to delete?'))window.location.href='{{url("/fake-game-delete/{$item?->id}")}}'" class="btn btn-sm btn-danger" >Delete</button>
                        </td>
                    </tr>
                    </div>
                    @endforeach
                    @else
                    @php
                        $nodata=1;
                    @endphp
                @endif
                </tbody>
            </table>

            @if (isset($nodata))
               <p class="text-center pt-3"> No Data Found.</p>
            @endif
    </div>
            <div class="pt-2 px-2 pb-1 mt-4 d-flex justify-content-end">
                {{$data->withQueryString()->links()}}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
