@extends('panel.layout.master')
@section('title','درباره ما')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">درباره ما</h4>
    </div>
    <div class="table-responsive">
        <table class="table features align-middle">
            <thead>
            <tr>
                <th>عنوان</th>
                <th>متن</th>
                <th>لینک</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->body }}</td>
                    <td>{{ $item->link }}</td>
                    <td class="d-flex">
                        <a href="{{ route('about.edit',['about' => $item->id]) }}" class="btn btn-primary ms-1">ویرایش</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
