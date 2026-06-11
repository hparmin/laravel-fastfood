@extends('panel.layout.master')
@section('title','اسلایدر ها')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">اسلایدر ها</h4>
        <a href="{{ route('slider.create') }}" class="btn btn-sm btn-outline-primary">ایجاد اسلایدر</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>عنوان</th>
                <th>متن</th>
                <th>عنوان لینک</th>
                <th>آدرس لینک</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sliders as $slider)
                <tr>
                    <td>{{ $slider->title }}</td>
                    <td>{{ $slider->body }}</td>
                    <td>{{ $slider->link_title }}</td>
                    <td>{{ $slider->link_address }}</td>
                    <td class="d-flex">
                        <form action="{{ route('slider.destroy',['slider' => $slider->id]) }}" method="post" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                        <a href="{{ route('slider.edit',['slider' => $slider->id]) }}" class="btn btn-primary ms-1">ویرایش</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
