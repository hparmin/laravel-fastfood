@extends('panel.layout.master')
@section('title','محصولات')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">محصولات حذف شده</h4>
        <div class="d-flex">
            <a href="{{ route('products.index') }}" class="ms-2 btn btn-sm btn-outline-primary">بازگشت</a>
        </div>
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
            @foreach($trashed_products as $product)
                <tr>
                    <td><img width="100px" style="max-height: 80px" class="rounded"
                             src="{{ asset('images/products/'.$product->primary_image )}}" alt="{{ $product->name }}">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>
                        {{ $product->category->name }}
                    </td>
                    <td>{{ number_format($product->price) }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->status == 1 ? 'فعال' : 'غیر فعال' }}</td>
                    <td class="d-flex">
                        <a href="{{ route('products.recovery',['product_id' => $product->id]) }}"
                           class="btn btn-outline-info ms-1">بازیابی</a>
                        <form class="ms-1" action="{{ route('products.hard.delete',['product_id' => $product->id]) }}"
                              method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف کامل</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $trashed_products->links('panel.layout.paginate') }}
    </div>
@endsection
