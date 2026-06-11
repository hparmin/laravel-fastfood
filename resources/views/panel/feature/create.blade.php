@extends('panel.layout.master')
@section('title','ایجاد اسلایدر')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h4 class="fw-bold">ایجاد ویژگی</h4>
    </div>
    <form action="{{ route('feature.store') }}" class="row gy-4" method="post">
        @csrf
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input value="{{ old('title') }}" name="title" type="text" class="form-control">
            @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">آیکن</label>
            <input value="{{ old('icon') }}" name="icon" type="text" class="form-control">
            @error('icon')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" rows="3" class="form-control">{{ old('body') }}</textarea>
            @error('body')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ایجاد ویژگی
            </button>
        </div>
    </form>
    <a href="{{ route('feature.index') }}" class="btn btn-outline-danger mt-3">
        بازگشت
    </a>

@endsection()
