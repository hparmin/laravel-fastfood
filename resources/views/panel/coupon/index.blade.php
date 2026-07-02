@extends('panel.layout.master')
@section('title','کد های تخفیف')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">کد های تخفیف</h4>
        <div>
            <a href="{{ route('coupon.create') }}" class="ms-2 btn btn-sm btn-outline-primary">ایجاد کوپن</a>
            <a href="{{ route('coupon.trash') }}" class="ms-2 btn btn-sm btn-outline-danger">سطل زباله</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table features align-middle">
            <thead>
            <tr>
                <th>کد</th>
                <th>درصد تخفیف</th>
                <th>تاریخ انقضا</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->percentage }}</td>
                    <td>{{ getJalaliDate($coupon->expired_at) }}</td>
                    <td class="d-flex">
                        <form action="{{ route('coupon.destroy',['coupon' => $coupon->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                        <a href="{{ route('coupon.edit',['coupon' => $coupon->id]) }}" class="btn btn-primary ms-1">ویرایش</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $coupons->links('panel.layout.paginate') }}
    </div>
@endsection
