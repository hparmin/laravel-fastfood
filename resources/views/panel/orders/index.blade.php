@extends('panel.layout.master')
@section('title','دسته بندی ها')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">سفارش ها</h4>
    </div>
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
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th>
                        {{ $order->id }}
                    </th>
                    <td>{{ $order->address->title }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                            <span
                                class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">{{ $order->payment_status ? 'موفق' : 'ناموفق' }}
                            </span>
                    </td>
                    <td>{{ number_format($order->paying_amount) }} تومان</td>
                    <td>{{ verta($order->created_at)->format('%d %B %Y') }}</td>
                    <td>
                        <div class="d-flex">
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-{{ $order->id }}">
                                    محصولات
                                </button>

                                <div class="modal fade" id="modal-{{ $order->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">محصولات سفارش
                                                    شماره {{ $order->id }}</h6>
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
                                                    @php
                                                    $total_price = 0;
                                                    @endphp
                                                    @foreach ($order->items()->with('product')->get() as $item)
                                                        @php
                                                            $total_price += $item->subtotal;
                                                        @endphp
                                                        <tr>
                                                            <th>
                                                                <img class="rounded"
                                                                     src="{{ asset('images/products/' . $item->product->primary_image) }}"
                                                                     width="80" alt=""/>
                                                            </th>
                                                            <td class="fw-bold">{{ $item->product->name }}</td>
                                                            <td>{{ $item->price }} تومان</td>
                                                            <td>
                                                                {{ $item->quantity }}
                                                            </td>
                                                            <td>{{ number_format($item->subtotal) }} تومان</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                @if($order->coupon)
                                                    <div style="display: flex; gap: 60px;">
                                                        <div>
                                                            <span>کد تخفیف:</span>
                                                            <span>{{ $order->coupon->code }}</span>
                                                        </div>
                                                        <div>
                                                            <span>درصد تخفیف:</span>
                                                            <span>{{ $order->coupon->percentage }}</span>
                                                        </div>
                                                        <div>
                                                            <span>میزان تخفیف:</span>
                                                            <span>{{ number_format($total_price-$order->paying_amount) }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-info ms-2">ویرایش</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $orders->withQueryString()->links('panel.layout.paginate') }}
    </div>
@endsection
