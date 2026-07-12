<div class="col-sm-12 col-lg-3">
    <ul class="list-group">
        <li class="list-group-item {{ request()->is('profile') ? 'actived' : '' }}">
            <a  href="{{ route('profile.index') }}">اطلاعات کاربر</a>
        </li>
        <li class="list-group-item {{ request()->is('*addresses*') ? 'actived' : '' }}">
            <a href="{{ route('profile.addresses') }}">آدرس ها</a>
        </li>
        <li class="list-group-item {{ request()->is('*orders*') ? 'actived' : '' }}">
            <a href="{{ route('profile.orders') }}">سفارشات</a>
        </li>
        <li class="list-group-item {{ request()->is('*transactions*') ? 'actived' : '' }}">
            <a href="{{ route('profile.transactions') }}">تراکنش ها</a>
        </li>
        <li class="list-group-item {{ request()->is('*wishlist*') ? 'actived' : '' }}">
            <a href="{{ route('wishlist.index') }}">لیست علاقه مندی ها</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('auth.logout') }}">خروج</a>
        </li>
    </ul>
</div>
