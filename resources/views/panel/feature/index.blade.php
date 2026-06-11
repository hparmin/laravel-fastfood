@extends('panel.layout.master')
@section('title','ویژگی ها')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">ویژگی ها</h4>
        <a href="{{ route('feature.create') }}" class="btn btn-sm btn-outline-primary">ایجاد ویژگی</a>
    </div>
    <div class="table-responsive">
        <table class="table features align-middle">
            <thead>
            <tr>
                <th>عنوان</th>
                <th>متن</th>
                <th>آیکن</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($features as $feature)
                <tr>
                    <td>{{ $feature->title }}</td>
                    <td>{{ $feature->body }}</td>
                    <td> <?php
                             echo $feature->icon
                             ?></td>
                    <td class="d-flex">
                        <form action="{{ route('feature.destroy',['feature' => $feature->id]) }}" method="post" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                        <a href="{{ route('feature.edit',['feature' => $feature->id]) }}" class="btn btn-primary ms-1">ویرایش</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
