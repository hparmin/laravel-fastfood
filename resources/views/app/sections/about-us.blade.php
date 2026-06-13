<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ">
                <div class="img-box">
                    <img src="{{ asset('/images/about-img.png') }}" alt=""/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            {{ $about_us->title }}
                        </h2>
                    </div>
                    <p>
                        {{ $about_us->body }}
                    </p>
                    <a href="{{ $about_us->link }}">
                        مشاهده بیشتر
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
