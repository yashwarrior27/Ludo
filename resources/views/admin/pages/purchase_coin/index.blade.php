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
                               <div class="col-4">
                                   <select name="filter" class="form-select" onchange="document.getElementById('search-form').submit()">
                                       <option value="">Select Status</option>
                                       <option value="1" {{request()->query('filter')=='1'?'selected':''}}>Released</option>
                                       <option value="0" {{request()->query('filter')=='0'?'selected':''}}>Locked</option>
                                   </select>
                               </div>
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
                <thead class="">
                  <tr>
                    <th scope="col" class="text-center">Sr No.</th>
                    <th scope="col" class="text-center">Register No.</th>
                    <th scope="col" class="text-center">Coins</th>
                    <th scope="col" class="text-center">Lock-In Days</th>
                    <th scope="col" class="text-center">Remaining Days</th>
                    <th scope="col" class="text-center">Release Status</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @if (isset($data) && count($data)>0)
                    @foreach ($data as $key => $item)
                    <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item?->User?->register_id??'-'}}</td>
                        <td class="text-center">{{$item?->coins??'-'}}</td>
                        <td class="text-center">{{$item?->lockin_days??'-'}}</td>
                        <td class="text-center">{{$item?->lockin_days-$item?->days_count??'-'}}</td>
                        <td class="text-center">
                            @if ($item?->withdrawal_status==0)
                               <span class="badge bg-danger">Locked</span>
                               @else
                               <span class="badge bg-success">Released</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="if (confirm('Are you sure you want to proceed?')) { window.location.href = '{{url("/admin/coin-released/{$item->id}")}}'; }" {{$item?->withdrawal_status==1?'disabled':''}}>Release</button>
                        </td>
                    </tr>
                    </div>
                    @endforeach
                @endif
                </tbody>

            </table>
    </div>
            <div class="pt-2 px-2 pb-1 mt-4 d-flex justify-content-end">
                {{$data->withQueryString()->links()}}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
