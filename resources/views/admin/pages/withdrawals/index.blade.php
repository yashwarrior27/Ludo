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
                                    <option value="pending" {{request()->query('filter')=='pending'?'selected':''}}>Pending</option>
                                    <option value="success" {{request()->query('filter')=='pending'?'selected':''}}>Success</option>
                                    <option value="rejected" {{request()->query('filter')=='pending'?'selected':''}}>Rejected</option>
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
                    <th scope="col" class="text-center">Mobile No.</th>
                    <th scope="col" class="text-center">UPI ID</th>
                    <th scope="col" class="text-center">Amount</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Transaction Id</th>
                    <th scope="col" class="text-center">Comment</th>
                    <th scope="col" class="text-center">Date</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @if (isset($data) && count($data)>0)
                    @foreach ($data as $key => $item)
                    <tr>
                        <th class="text-center">{{$key+1??'-'}}</th>
                        <td class="text-center">{{$item?->User?->mobile??'-'}}</td>
                        <td class="text-center">{{$item?->User?->UserDetail?->upi_id??'-'}}</td>
                        <td class="text-center">{{$item?->amount??'-'}}</td>
                        <td class="text-center">
                            @if ($item?->status=='pending')
                             <span class="badge bg-warning">Pending</span>
                             @elseif ($item?->status=='success')
                             <span class="badge bg-success">Success</span>
                             @else
                             <span class="badge bg-danger" >Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">{{$item?->transaction_id??'-'}}</td>
                        <td class="text-center">{{$item?->comment??'-'}}</td>
                          <td class="text-center">{{date('d-m-Y',strtotime($item?->created_at))??'-'}}</td>
                        <td>
                            @if (Auth::user()->id!=3)
                            <a href="{{url("/withdrawal-edit/{$item->id}")}}" class="btn btn-sm btn-warning" style="{{$item?->status!='pending'?'pointer-events:none;opacity:.6;':''}}" >Edit</a>
                            @endif
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
