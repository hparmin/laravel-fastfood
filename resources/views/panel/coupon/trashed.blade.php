@extends('panel.layout.master')
@section('title','کوپن های حذف شده')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">کوپن های حذف شده</h4>
        <div class="d-flex">
            <a href="{{ route('coupon.index') }}" class="ms-2 btn btn-sm btn-outline-primary">بازگشت</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table features align-middle">
            <thead>
            <tr>
                <th>کد</th>
                <th>تاریخ انقضا</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trashed_coupons as $trashed_coupon)
                <tr>
                    <td>{{ $trashed_coupon->code }}</td>
                    <td>{{ verta($trashed_coupon->expired_at)->formatJalaliDatetime() }}</td>
                    <td class="d-flex">
                        <form action="{{ route('coupon.hard.delete',['coupon_id' => $trashed_coupon->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                        <a href="{{ route('coupon.recovery',['coupon' => $trashed_coupon->id]) }}" class="btn btn-outline-info ms-1">بازیابی</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $trashed_coupons->links('panel.layout.paginate') }}
    </div>
@endsection
