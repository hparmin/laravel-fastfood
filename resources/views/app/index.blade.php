@extends('app.layout.master')
@section('title','طراحی وب')
@section('links')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin=""></script>
@endsection
@section('script')
    <script>
        var map = L.map('map').setView([30.287759, 57.052319], 14);
        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);
        var marker = L.marker([30.287759, 57.052319]).addTo(map)
            .bindPopup('<b>Arminhajipour.ir</b>').openPopup();
    </script>
@endsection
@section('content')
    @include('app.sections.feature')

    <!-- food section -->
    @include('app.sections.food_section')
    <!-- end food section -->

    <!-- about-us section -->
    @include('app.sections.about-us')
    <!-- end about-us section -->

    <!-- contact section -->
    @include('app.sections.contact')
    <!-- end contact section -->

@endsection

