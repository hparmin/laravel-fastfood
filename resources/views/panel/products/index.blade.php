@extends('panel.layout.master')
@section('title','محصولات')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">محصولات</h4>
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary">ایجاد محصول</a>
    </div>
    <div class="table-responsive">
        <table class="table features align-middle">
            <thead>
            <tr>
                <th>تصویر</th>
                <th>نام</th>
                <th>دسته بندی</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th>وضعبت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td><img width="100px" style="max-height: 80px" class="rounded" src="{{ asset('images/products/'.$product->primary_image )}}" alt="{{ $product->name }}"></td>
                    <td>{{ $product->name }}</td>
                    <td>
                    {{ $product->category->name }}
                    </td>
                    <td>{{ number_format($product->price) }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->status == 1 ? 'فعال' : 'غیر فعال' }}</td>
                    <td class="d-flex">
                        <a href="{{ route('products.edit',['product' => $product->id]) }}" class="btn btn-outline-primary ms-1">نمایش</a>
                        <a href="{{ route('products.edit',['product' => $product->id]) }}" class="btn btn-outline-info ms-1">ویرایش</a>
                        <form class="ms-1" action="{{ route('products.destroy',['product' => $product->id]) }}" method="post" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links('panel.layout.paginate') }}
    </div>
@endsection
