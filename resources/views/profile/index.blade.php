@extends('profile.layout.master')
@section('title','پنل کاربری')
@section('profile.content')
    <div class="col-sm-12 col-lg-9">
        <form class="vh-70" method="POST" action="{{ route('profile.update',['user' => $user->id]) }}">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col col-md-6">
                    <label class="form-label">نام و نام خانوادگی</label>
                    <input type="name" name="name" class="form-control" value="{{ $user->name; }}">
                    <div class="form-text text-danger">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">ایمیل</label>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                    <div class="form-text text-danger">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col col-md-6">
                    <label class="form-label">شماره تلفن</label>
                    <input type="text" disabled="" class="form-control" value="{{ $user->cellphone }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">ویرایش</button>
        </form>
    </div>
@endsection
