@extends('panel.layout.master')
@section('title','ویرایش')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h4 class="fw-bold">ایجاد اسلایدر</h4>
    </div>
    <form action="{{ route('slider.update',['slider' => $slider->id ]) }}" class="row gy-4" method="post">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input value="{{ $slider->title }}"  name="title" type="text" class="form-control">
            @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">عنوان لینک</label>
            <input value="{{$slider->link_title}}" name="link_title" type="text" class="form-control">
            @error('link_title')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">آدرس لینک</label>
            <input value="{{$slider->link_address}}" name="link_address" type="text" class="form-control">
            @error('link_address')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" rows="3" class="form-control">{{$slider->body}}</textarea>
            @error('body')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
               بروز رسانی
            </button>
        </div>
    </form>
@endsection
