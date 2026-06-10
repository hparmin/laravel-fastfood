@include('panel.layout.header')

<div class="container-fluid">
    <div class="row">
        @include('panel.layout.sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            @yield('content')
        </main>
    </div>
</div>

@include('panel.layout.footer')
