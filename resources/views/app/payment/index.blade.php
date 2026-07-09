@extends('app.layout.master')
@if($status == 'OK')
    @section('title','پرداخت موفق')
@elseif($status == 'NOK')
    @section('title','پرداخت ناموفق')
@else
    @section('title','خطای غیر منتظره')
@endif

@section('content')
    <section class="auth_section ">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3 text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                @if($status == 'OK')
                                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         version="1.1" width="50" height="50" viewBox="0 0 256 256"
                                         xml:space="preserve">
                                       <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                          transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                           <path
                                               d="M 28.5 65.5 c -1.024 0 -2.047 -0.391 -2.829 -1.172 c -1.562 -1.562 -1.562 -4.095 0 -5.656 l 33 -33 c 1.561 -1.562 4.096 -1.562 5.656 0 c 1.563 1.563 1.563 4.095 0 5.657 l -33 33 C 30.547 65.109 29.524 65.5 28.5 65.5 z"
                                               style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(236,0,0); fill-rule: nonzero; opacity: 1;"
                                               transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                           <path
                                               d="M 61.5 65.5 c -1.023 0 -2.048 -0.391 -2.828 -1.172 l -33 -33 c -1.562 -1.563 -1.562 -4.095 0 -5.657 c 1.563 -1.562 4.095 -1.562 5.657 0 l 33 33 c 1.563 1.562 1.563 4.095 0 5.656 C 63.548 65.109 62.523 65.5 61.5 65.5 z"
                                               style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(236,0,0); fill-rule: nonzero; opacity: 1;"
                                               transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                           <path
                                               d="M 45 90 C 20.187 90 0 69.813 0 45 C 0 20.187 20.187 0 45 0 c 24.813 0 45 20.187 45 45 C 90 69.813 69.813 90 45 90 z M 45 8 C 24.598 8 8 24.598 8 45 c 0 20.402 16.598 37 37 37 c 20.402 0 37 -16.598 37 -37 C 82 24.598 65.402 8 45 8 z"
                                               style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(236,0,0); fill-rule: nonzero; opacity: 1;"
                                               transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                       </g>
                                    </svg>
                                @endif
                                <!-- <i class="bi bi-x-circle-fill text-danger fs-1"></i> -->
                                @if($status == 'OK')
                                    <h5 class="mt-3 text-success">پرداخت شما با موفقیت انجام شد</h5>
                                    @if(isset($ref_number))
                                        <h6 class="mt-3">شماره پیگیری: {{ $ref_number }}</h6>
                                    @endif
                                @elseif($status == 'NOK')
                                    <h5 class="mt-3 text-danger">خطا در پرداخت</h5>
                                    <h6 class="mt-3">در صورت کسر مبلغ از حساب، با فروشگاه تماس بگیرید.</h6>
                                @else
                                    <h5 class="mt-3 text-danger">خطای نا شناخته</h5>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between">
                                @if($status == 'OK')
                                    <a href="#" class="btn btn-primary">مشاهده سفارش</a>
                                @else
                                    <a href="{{ route('cart') }}" class="btn btn-primary">سبد خرید</a>
                                @endif
                                <a href="{{ route('home') }}" class="btn btn-dark">بازگشت به سایت</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
