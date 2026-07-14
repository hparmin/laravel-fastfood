@extends('panel.layout.master')
@section('title','تراکنش ها')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">تراکنش ها</h4>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>شماره پیگیری تراکنش</th>
                <th>نام کاربر</th>
                <th>آدرس</th>
                <th>وضعیت پرداخت</th>
                <th>مبلغ تراکنش</th>
                <th>تاریخ</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <th>
                        {{ $transaction->ref_number }}
                    </th>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->order->address->title }}</td>
                    <td>
                            <span
                                class="{{ $transaction->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">{{ $transaction->status }}
                            </span>
                    </td>
                    <td>{{ number_format($transaction->amount) }} تومان</td>
                    <td>{{ verta($transaction->created_at)->format('%d %B %Y') }}</td>
                    <td>
                        <div class="d-flex">
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-{{ $transaction->id }}">
                                    محصولات
                                </button>

                                <div class="modal fade" id="modal-{{ $transaction->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">محصولات تراکنش
                                                    شماره {{ $transaction->id }}</h6>
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
                                                    @foreach ($transaction->order->items as $item)
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
                                                @if($transaction->order->coupon)
                                                    <div style="display: flex; gap: 60px;">
                                                        <div>
                                                            <span>کد تخفیف:</span>
                                                            <span>{{ $transaction->order->coupon->code }}</span>
                                                        </div>
                                                        <div>
                                                            <span>درصد تخفیف:</span>
                                                            <span>{{ $transaction->order->coupon->percentage }}</span>
                                                        </div>
                                                        <div>
                                                            <span>میزان تخفیف:</span>
                                                            <span>{{ number_format($total_price-$transaction->order->paying_amount) }}</span>
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
        {{ $transactions->withQueryString()->links('panel.layout.paginate') }}
    </div>
@endsection
