@extends('panel.layout.master')
@section('title','دسته بندی ها')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">دسته بندی ها</h4>
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-primary">ایجاد دسته بندی</a>
    </div>
    <div class="table-responsive">
        <table class="table features align-middle">
            <thead>
            <tr>
                <th>نام</th>
                <th>وضعبت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->status == 1 ? 'فعال' : 'غیر فعال' }}</td>
                    <td class="d-flex">
                        <form action="{{ route('category.destroy',['category' => $category->id]) }}" method="post" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                        <a href="{{ route('category.edit',['category' => $category->id]) }}" class="btn btn-primary ms-1">ویرایش</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
