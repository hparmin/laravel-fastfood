
<!-- feature section -->
<section class="card-area layout_padding">
    <div class="container">
        <div class="row gy-5">
            @foreach($features as $feature)
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="card-icon-wrapper">
                                @php
                                    echo $feature->icon
                                @endphp
                            </div>
                            <p class="card-text fw-bold"> {{ $feature->title }}</p>
                            <p class="card-text"> {{ $feature->body }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- end feature section -->
