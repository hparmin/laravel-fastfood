@php
    use App\Models\category;

    //دستور زیر کتیگوری های فعال و محصولات متعلق به اون ها رو برمیگردونه:
    $categories = Category::where('status', 1)->with(['products' => function ($query) {
        $query->where('status', 1);
//              ->where('quantity', '>', 0);
    }])->get();
@endphp
@foreach($categories as $category)
    @php
        if (count($category->products) == 0){
            continue;
        }else{
            $loop_start = $loop->index+1;
            break;
        }
    @endphp
@endforeach
<section class="food_section layout_padding-bottom">
    <div class="container" x-data="{ tab: {{$loop_start}} }">
        <div class="heading_container heading_center">
            <h2>
                منو محصولات
            </h2>
        </div>
        <ul class="filters_menu">
            @foreach($categories as $category)
                @php
                    if (count($category->products) == 0){
                        continue;
                    }
                @endphp
                <li :class="tab === {{ $loop->index + 1 }} ? 'active' : ''"
                    @click="tab = {{ $loop->index + 1 }}">{{ $category->name }}</li>
            @endforeach
        </ul>
        <div class="filters-content">

            @foreach($categories as $category)
                @php
                    $products = $category->products;
                    if (count($products) == 0){
                        continue;
                    }
                @endphp
                <div x-show="tab === {{ $loop->index + 1 }}">
                    <div class="row grid">
                        @foreach($products as $product)
                            @if($loop->index < 3)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="box">
                                        <div>
                                            <div class="img-box">
                                                <img class="img-fluid"
                                                     src="{{ asset('images/products/'.$product->primary_image) }}"
                                                     alt="">
                                            </div>
                                            <div class="detail-box">
                                                <h5>
                                                    <a href="{{ route('products.single',['product' => $product->slug ]) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h5>
                                                <p>
                                                    {{ $product->description }}
                                                </p>
                                                <div class="options">
                                                    @if($product->is_sale)
                                                        <h6>
                                                            <del>{{ $product->price }}</del>
                                                            <span>
                                                                @php
                                                                    $off_percantage = 100-($product->sale_price * 100 / $product->price);
                                                                @endphp
                                                                <span
                                                                    class="text-danger">({{round($off_percantage)}}%)</span>
                                                                {{ $product->sale_price }}
                                                                <span>تومان</span>
                                                            </span>
                                                        </h6>
                                                    @else
                                                        <h6>
                                                            {{ $product->price }}
                                                            <span>تومان</span>
                                                        </h6>
                                                    @endif
                                                    <div class="d-flex">
                                                        <a class="me-2" href="{{ route('addToCart',['product_id' => $product->id]) }}">
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
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="btn-box">
            <a href="">
                مشاهده بیشتر
            </a>
        </div>
    </div>
</section>
