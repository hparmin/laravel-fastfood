@extends('panel.layout.master')
@section('title','ایجاد اسلایدر')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h4 class="fw-bold">ایجاد ویژگی</h4>
    </div>
    <form action="{{ route('about.update',['about' => $about->id]) }}" class="row gy-4" method="post">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input value="{{ $about->title }}" name="title" type="text" class="form-control">
            @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">لینک</label>
            <input value="{{ $about->link }}" name="link" type="text" class="form-control">
            @error('link')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" rows="3" class="form-control">{{ $about->body }}</textarea>
            @error('body')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                بروزرسانی درباره ما
            </button>
        </div>
    </form>
    <a href="{{ route('about.index') }}" class="btn btn-outline-danger mt-3">
        بازگشت
    </a>

@endsection()
