@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Order
    <a href="{{url('admin/order')}}" class=" btn btn-sm btn-primary shadow-sm float-right ml-3"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Back </a>
    <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            {{-- <th>#</th> --}}
            <th>#Order No.</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Qty.</th>
            {{-- <th>Charge</th>
            <th>Total</th> --}}
            <th>Order date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            {{-- <td>{{$order->id}}</td> --}}
            <td>{{$order->order_number}}</td>
            <td>{{$order->first_name}} {{$order->last_name}}</td>
            <td>{{$order->phone}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{$order->created_at}}</td>
            {{-- <td>AED {{$order->shipping->price}}</td>
            <td>AED {{number_format($order->total_amount,2)}}</td> --}}
            <td>
                @if($order->status=='new')
                  <span class="badge badge-primary">NEW</span>
                @elseif($order->status=='confirm')
                  <span class="badge badge-warning">CONFIRM</span>
                @elseif($order->status=='delivered')
                  <span class="badge badge-success">DELIVERED</span>
                @else
                  <span class="badge badge-danger">{{$order->status}}</span>
                @endif
            </td>
            <td>
                {{-- <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-toggle-on"></i></a>
                <a href="{{route('order.edit-order',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>--}}
                <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                  @csrf
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure to delete?');"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">ORDER INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Order Number</td>
                        <td> : {{$order->order_number}}</td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Product</td>
                        <td> : {{$order->product_name}}</td>
                    </tr>
                    <tr>
                        <td>Variants</td>
                        <td> : @if($order->size) Size: ({{ $order->size }}) @endif  @if($order->color) Color: ({{ $order->color }}) @endif </td>
                    </tr>
                    {{-- <tr>
                        <td>Quantity</td>
                        <td> : {{$order->quantity}}</td>
                    </tr> --}}
                @if(!empty($order->quantity_selected))
                    <tr>
                        <td>Quantity Choosen</td>
                        <td> : {{ $order->quantity_selected }}</td>
                    </tr>
                @else
                    <tr>
                        <td>Quantity</td>
                        <td> : {{ $order->quantity }}</td>
                    </tr>
                @endif
                    <tr>
                        <td>Order Status</td>
                        <td> : {{ ucfirst($order->status) }}</td>
                    </tr>

                    {{-- <tr>
                      <td>Coupon</td>
                      <td> : AED {{number_format($order->coupon,2)}}</td>
                    </tr> --}}
                    <tr>
                        <td>Sub Total</td>
                        <td> : AED {{number_format($order->sub_total,2)}}</td>
                    </tr>
                    <tr>
                        <td>Shipping Charge</td>
                        <td> : AED {{$order->shipping->price}}</td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td> : AED {{number_format($order->total_amount,2)}}</td>
                    </tr>
                     {{--<tr>
                        <!-- <td>Payment Method</td>
                        <td> : @if($order->payment_method=='cod') Cash on Delivery @else Paypal @endif</td> -->
                        <td>Payment Method</td>
                        <td> :
                            @if($order->payment_method == 'cod')
                                Cash on Delivery
                            @elseif($order->payment_method == 'paypal')
                                Paypal
                            @elseif($order->payment_method == 'cardpay')
                                Card Payment
                            @endif
                        </td>
                    </tr>--}}
                    <!-- <tr>
                        <td>Payment Status</td>
                        <td> : {{$order->payment_status}}</td>
                    </tr> -->
                    {{-- <tr>
                      <td>Payment Status</td>
                      <td> :
                          @if($order->payment_status == 'paid')
                              <span class="badge badge-success">Paid</span>
                          @elseif($order->payment_status == 'unpaid')
                              <span class="badge badge-danger">Unpaid</span>
                          @else
                              {{$order->payment_status}}
                          @endif
                      </td>
                  </tr> --}}

              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Full Name</td>
                        <td> : {{$order->first_name}} {{$order->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$order->email}}</td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td> : {{$order->phone}}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td> : {{$order->address1}}, {{$order->address2}}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td> : {{$order->country}}</td>
                    </tr>
                    <tr>
                        <td>Post Code</td>
                        <td> : {{$order->post_code}}</td>
                    </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
