<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آرمین حاجی پور | @yield('title') </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @yield('links')

</head>

<body>
<div class="
{{request()->is('/') ? "" : "sub_page"}}
">
    <div class="hero_area">
        <div class="bg-box">
            <img src="{{ asset('/images/hero-bg.jpg') }}" alt="">
        </div>
        <!-- header section strats -->
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="{{ route('home') }}">
                            <span>
                                ArminHajipour.ir
                            </span>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item {{request()->is('/') ? "active" : ""}}">
                                <a class="nav-link" href="{{ route('home') }}">صفحه اصلی</a>
                            </li>
                            <li class="nav-item {{request()->is('menu') ? "active" : ""}}">
                                <a class="nav-link" href="{{ route('products.menu') }}">منو</a>
                            </li>
                            <li class="nav-item {{request()->is('about-us') ? "active" : ""}}">
                                <a class="nav-link" href="{{ route('app.about-us') }}">درباره ما</a>
                            </li>
                            <li class="nav-item {{request()->is('contact_us') ? "active" : ""}}">
                                <a class="nav-link" href="{{ route('contact.index') }}">تماس باما</a>
                            </li>
                        </ul>
                        <div class="user_option">
                            <a class="cart_link position-relative" href="{{ route('cart') }}">
                                <i class="bi bi-cart-fill text-white fs-5"></i>
                                <span class="position-absolute top-0 translate-middle badge rounded-pill">
                                        3
                                    </span>
                            </a>
                            @auth()
                            <a href="{{ route('profile.index') }}" class="btn-auth">
                                حساب کاربری
                            </a>
                            @endauth
                            @guest()
                                <a href="{{ route('auth.login') }}" class="btn-auth">
                                    ورود
                                </a>
                            @endguest
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
        <!-- slider section -->
        @if(request()->is('/'))
            @include('app.layout.slider')
        @endif
        <!-- end slider section -->
    </div>
</div>
