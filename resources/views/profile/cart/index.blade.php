@extends('app.layout.master')
@section('title','سبد خرید')
@section('content')
    @if($cart_items->isEmpty())
        <div class="cart-empty">
            <div class="text-center">
                <div>
                    <i class="bi bi-basket-fill" style="font-size: 80px"></i>
                </div>
                <h4 class="text-bold">سبد خرید شما خالی است</h4>
                <a href="{{ route('products.menu') }}">مشاهده محصولات</a>
            </div>
        </div>
    @else
        <section class="single_page_section layout_padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row gy-5">
                            <div class="col-12">
                                <div class="table-responsive">
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
                                        @foreach($cart_items as $item)
                                            <tr>
                                                <th>
                                                    <img class="rounded"
                                                         src="{{ asset('images/products/'.$item->product->primary_image) }}"
                                                         width="100" alt="">
                                                </th>
                                                <td class="fw-bold">
                                                    <a href="{{ route('products.single',['product' => $item->product->slug]) }}">{{ $item->product->name }}</a>
                                                </td>
                                                <td>
                                                    @if($item->product->is_sale)
                                                        <div>
                                                            <del>{{ number_format($item->product->price) }}</del>
                                                            {{ number_format($item->product->sale_price) }}
                                                            تومان
                                                        </div>
                                                        <div class="text-danger">
                                                            {{ $item->product->off_percent }}% تخفیف
                                                        </div>
                                                    @else
                                                        <div>
                                                            {{ number_format($item->product->final_price) }} تومان
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="input-counter">
                                                        <a href="{{ route('addToCart',['product_id' => $item->product->id ]) }}"
                                                           class="plus-btn">
                                                            +
                                                        </a>
                                                        <div class="input-number">{{ $item->qty }}</div>
                                                        <a href="{{ route('removeFromToCart',['product_id' => $item->product->id ]) }}"
                                                           class="minus-btn">
                                                            -
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ number_format($item->product->final_price*$item->qty) }}</span>
                                                    <span class="ms-1">تومان</span>
                                                </td>
                                                <td>
                                                    <form method="post"
                                                          action="{{ route('destroyFromCart',['cart'=>$item->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="border:none; background: none;">
                                                            <i class="bi bi-x text-danger fw-bold fs-4 cursor-pointer"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ route('deleteCart') }}" class="btn btn-primary mb-4">پاک کردن سبد خرید</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-md-6">
                                <form action="{{ route('coupon.check') }}">
                                    <div class="input-group mb-3">
                                        <input type="text" value="{{ old('code') }}" name="code" class="form-control"
                                               placeholder="کد تخفیف">

                                        <button type="submit" class="input-group-text" id="basic-addon2">
                                            اعمال کد تخفیف
                                        </button>
                                    </div>
                                    @error('code')
                                    <div class="form-text text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </form>
                            </div>
                            <div class="col-12 col-md-6 d-flex justify-content-end align-items-baseline"
                                 style="gap:10px">
                                <div class="ml-5">
                                    @if($addresses)
                                        انتخاب آدرس:
                                    @else
                                        آدرس ندارید
                                    @endif
                                </div>
                                @if($addresses)
                                    <select style="width: 200px;" class="form-select ms-3"
                                            aria-label="Default select example">
                                        @foreach($addresses as $address)
                                            <option value="{{ $address->id }}">{{ $address->title }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <a href="{{ route('addresses.create') }}" class="btn btn-primary">
                                    ایجاد آدرس
                                </a>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold">مجموع سبد خرید</h5>
                                        <ul class="list-group mt-4">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>مجموع قیمت :</div>
                                                <div>
                                                    {{ number_format($before_off_payment) }} تومان
                                                </div>
                                            </li>
                                            @if($before_off_payment-$after_off_payment !== 0)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <div>تخفیف محصولات:
                                                        {{--                                                    <span class="text-danger ms-1">{{ intval(100-($after_off_payment*100/$before_off_payment)) }}%</span>--}}
                                                    </div>
                                                    <div class="text-danger">
                                                        {{ number_format($before_off_payment-$after_off_payment) }}
                                                        تومان
                                                    </div>
                                                </li>
                                            @endif
                                            @if($coupon)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <div>
                                                        <a class="remove-coupon" href="{{ route('coupon.destroy.session.byuser') }}">
                                                            <i class="bi bi-x text-danger fw-bold fs-4 cursor-pointer"></i>
                                                        </a>
                                                        کد تخفیف:
                                                        <span class="text-danger ms-1">{{ $coupon['percent'] }}%</span>
                                                    </div>
                                                    <div class="text-danger">
                                                        {{ number_format($after_off_payment*$coupon['percent']/100) }}
                                                        تومان
                                                    </div>
                                                </li>
                                            @endif
                                            <li class="list-group-item d-flex justify-content-between">
                                                <div>قیمت پرداختی :</div>
                                                <div>
                                                    @if($coupon)
                                                        {{ number_format($after_off_payment-$after_off_payment*$coupon['percent']/100) }}
                                                        تومان
                                                    @else
                                                        {{ number_format($after_off_payment) }}
                                                        تومان
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                        <button class="user_option btn-auth mt-4">پرداخت</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
