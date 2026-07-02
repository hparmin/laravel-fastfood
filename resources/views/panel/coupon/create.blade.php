@extends('panel.layout.master')
@section('title','ایجاد کد تخفیف')
@section('header_links')
    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
    <script type="text/javascript"
            src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
@endsection
@section('dashboard-scripts')
    <script type="text/javascript">
        jalaliDatepicker.startWatch({time: true});
    </script>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h4 class="fw-bold">ایجاد کد تخفیف</h4>
    </div>
    <form action="{{ route('coupon.store') }}" class="row gy-4" method="post">
        @csrf
        <div class="col-md-4">
            <label class="form-label">کد</label>
            <input value="{{ old('code') }}" name="code" type="text" class="form-control">
            @error('code')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">درصد تخفیف</label>
            <input value="{{ old('percentage') }}" name="percentage" type="text" class="form-control">
            @error('percentage')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">تاریخ انقضا</label>
            <input data-jdp name="expired_at" value="{{ old('expired_at') }}" type="text" class="form-control"/>
            <div class="form-text text-danger">
                @error('expired_at')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div>
            <button class="btn btn-outline-info mt-3" type="submit">
                ایجاد
            </button>
        </div>
    </form>
    <a href="{{ route('coupon.index') }}" class="btn btn-outline-danger mt-3">
        بازگشت
    </a>

@endsection()
