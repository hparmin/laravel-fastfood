@extends('panel.layout.master')
@section('title','ایجاد دسته بندی')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h4 class="fw-bold">ویرایش دسته بندی</h4>
    </div>
    <form action="{{ route('category.update',['category' => $category->id]) }}" class="row gy-4" method="post">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">نام دسته بندی</label>
            <input value="{{ $category->name }}" name="name" type="text" class="form-control">
            @error('name')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option {{ $category->status === 1 ? 'selected' : '' }} value="1">فعال</option>
                <option {{ $category->status === 0 ? 'selected' : '' }} value="0">غیر فعال</option>
            </select>
            @error('status')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش
            </button>
        </div>
    </form>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-danger mt-3">
        بازگشت
    </a>

@endsection()
