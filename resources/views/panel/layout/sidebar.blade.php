<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link
                {{ request()->is('panel') ? 'active' : '' }}
                " aria-current="page" href="{{ route('panel.index') }}">
                    <i class="bi bi-grid me-2"></i>
                    داشبورد
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-people me-2"></i>
                    کاربران
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('slider.index') }}">
                    <i class="bi bi-people me-2"></i>
                    اسلایدر
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                {{ request()->is('products*') ? 'active' : '' }}
                " href="{{ route('products.index') }}">
                    <i class="bi bi-box-seam me-2"></i>
                    محصولات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                {{ request()->is('categories*') ? 'active' : '' }}
                " href="{{ route('categories.index') }}">
                    <i class="bi bi-grid-3x3-gap me-2"></i>
                    دسته بندی
                </a>
            </li>
            <li class="nav-item ">
            <a class="nav-link {{ request()->is('*order*') ? 'active' : '' }}" href="{{ route('panel.orders') }}">
                    <i class="bi bi-basket me-2"></i>
                    سفارشات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"   href="#">
                    <i class="bi bi-currency-dollar me-2"></i>
                    تراکنش ها
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('coupon*') ? 'active' : '' }}" href="{{ route('coupon.index') }}">
                    <i class="bi bi-percent me-2"></i>
                    تخفیف ها
                </a>
            </li>
            <li class="nav-item dropdown-center">
                <a class="nav-link dropdown-toggle
                {{ request()->is('sliders*') ? 'active' : '' }}
                {{ request()->is('feature*') ? 'active' : '' }}
                {{ request()->is('about*') ? 'active' : '' }}
                {{ request()->is('footer*') ? 'active' : '' }}
                " href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-gear  me-2"></i>
                    تنظیمات سایت
                </a>
                <ul class="dropdown-menu sidebar-menu">
                    <li>
                        <a class="dropdown-item" href="{{route('slider.index')}}">اسلایدر صفحه اصلی</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('feature.index') }}">بخش ویژگی ها</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('about.index') }}">بخش درباره ما</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('contact.showall') }}">پیام ها</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('footer.index') }}">بخش فوتر</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
