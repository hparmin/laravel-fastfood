@extends('profile.layout.master')
@section('title','لیست علاقه مندی ها')
@section('profile.content')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>محصول</th>
                    <th>نام</th>
                    <th>قیمت</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($wishlist as $item)
                    <tr>
                        <th>
                            <img class="rounded" src="{{ asset('images/products/'.$item->product->primary_image) }}"
                                 width="100"
                                 alt=""/>
                        </th>
                        <td class="fw-bold">
                            <a href="{{ route('products.single', ['product' => $item->product->slug]) }}">
                                {{ $item->product->name }}
                            </a>
                        </td>
                        <td>
                            @if ($item->product->is_sale)
                                <div>
                                    <del>{{ $item->product->price }}</del>
                                    {{ number_format($item->product->sale_price) }}
                                    تومان
                                </div>
                                @php
                                    $off_percantage = 100-($item->product->sale_price * 100 / $item->product->price);
                                @endphp
                                <span
                                    class="text-danger">({{round($off_percantage)}}%)</span>
                            @else
                                <div>
                                    {{ number_format($item->product->price) }}
                                    تومان
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('removeFromWishlist',['wishlist' => $item->id]) }}"
                               class="btn btn-primary">
                                حذف
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
