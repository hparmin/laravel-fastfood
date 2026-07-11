@extends('app.layout.master')
@section('title', $product->name)

@section('content')
    @php
        $product_images = $product->images;
    @endphp
    <section class="single_page_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row gy-5">
                        <div class="col-sm-12 col-lg-6">
                            <h3 class="fw-bold mb-4">{{ $product->name }}</h3>

                            @if ($product->is_sale)
                                <h5 class="mb-3">
                                    <del>{{ $product->price }}</del>
                                    {{ $product->sale_price }}
                                    تومان
                                    <div class="text-danger fs-6">
                                        @php
                                            $off_percantage = 100-($product->sale_price * 100 / $product->price);
                                        @endphp
                                        {{round($off_percantage)}}% تخفیف
                                    </div>
                                </h5>
                            @else
                                <h5 class="mb-3">
                                    {{ $product->price }}
                                    تومان
                                </h5>
                            @endif
                            <p>{{ $product->description }}</p>

                            <form x-data="{ quantity : 1 }" action="{{ route('addToCart') }}" method="get" class="mt-5 d-flex">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" :value="quantity">
                                <button type="submit" class="btn-add">افزودن به سبد خرید</button>
                                <div class="input-counter ms-4">
                                    <span @click="quantity < {{ $product->quantity }} && quantity++" class="plus-btn">
                                        +
                                    </span>
                                    <div class="input-number" x-text="quantity">1</div>
                                    <span @click="quantity &gt; 1 &amp;&amp; quantity--" class="minus-btn">
                                        -
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @if(!count($product_images) == 0)
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                                data-bs-slide-to="0" class="active" aria-current="true"></button>
                                    @endif
                                    @foreach($product_images as $product_image)
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                                data-bs-slide-to="{{ $loop->index+1 }}" class=""
                                                aria-current=""></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/products/'.$product->primary_image) }}"
                                             class="d-block w-100" alt="...">
                                    </div>
                                    @foreach($product_images as $product_image)
                                        <div class="carousel-item">
                                            <img src="{{ asset('images/products/'.$product_image->image)  }}"
                                                 class="d-block w-100" alt="...">
                                        </div>
                                    @endforeach
                                </div>
                                @if(!count($product_images) == 0)
                                    <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr>

    <section class="food_section my-5">
        <div class="container">
            <div class="row gx-3">
                @foreach($random_product as $prod)
                    <div class="col-sm-6 col-lg-3">
                        <div class="box">
                            <div>
                                <div class="img-box">
                                    <img class="img-fluid"
                                         src="{{ asset('images/products/'.$prod->primary_image) }}"
                                         alt="">
                                </div>
                                <div class="detail-box">
                                    <h5>
                                        <a href="{{ route('products.single',['product' => $prod->slug ]) }}">
                                            {{ $prod->name }}
                                        </a>
                                    </h5>
                                    <p>
                                        {{ $prod->description }}
                                    </p>
                                    <div class="options">
                                        @if($prod->is_sale)
                                            <h6>
                                                <del>{{ $prod->price }}</del>
                                                <span>
                                                                @php
                                                                    $off_percantage = 100-($prod->sale_price * 100 / $prod->price);
                                                                @endphp
                                                                <span
                                                                    class="text-danger">({{round($off_percantage)}}%)</span>
                                                                {{ $prod->sale_price }}
                                                                <span>تومان</span>
                                                            </span>
                                            </h6>
                                        @else
                                            <h6>
                                                {{ $prod->price }}
                                                <span>تومان</span>
                                            </h6>
                                        @endif
                                        <div class="d-flex">
                                            <a class="me-2" href="">
                                                <i class="bi bi-cart-fill text-white fs-6"></i>
                                            </a>
                                            <a href="{{ route('addToWishlist',['product_id' => $product->id]) }}">
                                                <i class="bi bi-heart-fill  text-white fs-6"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
