@include('app.layout.header')
<section class="profile_section layout_padding">
    <div class="container">
        <div class="row">
            @include('profile.layout.sidebar')
            @yield('profile.content')
        </div>
    </div>
</section>


@include('app.layout.footer')
