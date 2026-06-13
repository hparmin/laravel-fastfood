@extends('panel.layout.master')
@section('title','ایجاد اسلایدر')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h4 class="fw-bold">ایجاد ویژگی</h4>
    </div>
    <form action="" class="row gy-4" method="post">
        @csrf
        <div class="col-md-4">
            <label class="form-label">نام</label>
            <input disabled value="{{ $contact_us->name }}" name="title" type="text" class="form-control">
            @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">موضوع</label>
            <input disabled value="{{ $contact_us->subject }}" name="link" type="text" class="form-control">
            @error('link')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">ایمیل</label>
            <input disabled value="{{ $contact_us->email }}" name="email" type="email" class="form-control">
            @error('email')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea disabled name="body" rows="3" class="form-control">{{ $contact_us->body }}</textarea>
            @error('body')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    </form>
    <a href="{{ route('contact.showall') }}" class="btn btn-outline-danger mt-3">
        بازگشت
    </a>

@endsection()
