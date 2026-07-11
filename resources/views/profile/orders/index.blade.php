@extends('profile.layout.master')
@section('title','لیست علاقه مندی ها')
@section('profile.content')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>شماره سفارش</th>
                    <th>آدرس</th>
                    <th>وضعیت</th>
                    <th>وضعیت پرداخت</th>
                    <th>قیمت کل</th>
                    <th>تاریخ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <th>
                            {{ $order->id }}
                        </th>
                        <td>{{ $order->address->title }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if($order->payment_status)
                                <span class="text-success">پرداخت شده</span>
                            @else
                                <span class="text-danger">پرداخت نشده</span>
                            @endif
                        </td>
                        <td>{{ number_format($order->paying_amount) }}</td>
                        <td>{{ verta($order->created_at)->format('y/m/j') }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $order->id }}">
                                محصولات
                            </button>
                            <div class="modal fade" id="modal-{{ $order->id }}" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title">محصولات سفارش
                                                شماره 25</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table align-middle">
                                                <thead>
                                                <tr>
                                                    <th>محصول</th>
                                                    <th>نام</th>
                                                    <th>قیمت</th>
                                                    <th>تعداد</th>
                                                    <th>قیمت کل</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order->items()->with('product')->get() as $item)
                                                    <tr>
                                                        <th>
                                                            <img class="rounded" src="{{ asset('/images/products/'.$item->product->primary_image) }}" width="80"
                                                                 alt="">
                                                        </th>
                                                        <td class="fw-bold"><a href="{{ route('products.single',['product' => $item->product->slug ]) }}">{{ $item->product->name }}</a></td>
                                                        <td>{{ $item->price }} تومان</td>
                                                        <td>
                                                            {{ $item->quantity }}
                                                        </td>
                                                        <td>{{ $item->subtotal }} تومان</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->withQueryString()->links('panel.layout.paginate') }}
    </div>
@endsection
