@extends('profile.layout.master')
@section('title','پنل کاربری')
@section('profile.content')
    <div class="col-sm-12 col-lg-9">
        <a href="{{ route('addresses.create') }}" class="btn btn-primary mb-4">
            ایجاد آدرس جدید
        </a>

        @foreach($addresses as $address)
            <div class="card card-body">
                <div class="row g-4">
                    <div class="col col-md-4">
                        <label class="form-label">عنوان</label>
                        <input disabled="" type="text" value="{{ $address->title }}" class="form-control">
                    </div>
                    <div class="col col-md-4">
                        <label class="form-label">شماره تماس</label>
                        <input disabled="" type="text" value="{{ $address->cellphone }}" class="form-control">
                    </div>
                    <div class="col col-md-4">
                        <label class="form-label">کد پستی</label>
                        <input disabled="" type="text" value="{{ $address->postal_code }}" class="form-control">
                    </div>
{{--                    <div class="col col-md-6">--}}
{{--                        <label class="form-label">استان</label>--}}
{{--                        <input disabled="" type="text" value="{{ $address->Province->name }}" class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="col col-md-6">--}}
{{--                        <label class="form-label">شهر</label>--}}
{{--                        <input disabled="" type="text" value="{{ $address->City->name }}" class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="col col-md-12">--}}
{{--                        <label class="form-label">آدرس</label>--}}
{{--                        <textarea disabled="" type="text" rows="5" class="form-control">{{ $address->address }}</textarea>--}}
{{--                    </div>--}}
                </div>
                <div class="mt-4 d-flex">
                    <a href="{{ route('addresses.edit',['address' => $address->id ]) }}" class="btn btn-primary">ویرایش</a>
                    <form class="d-flex" method="post" action="{{ route('addresses.destroy',['address' => $address->id ]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ms-2 btn btn-danger" style="background-color: darkred; color: #fff;">حذف</button>
                    </form>
                </div>
            </div>
            <hr>
        @endforeach
    </div>
@endsection
