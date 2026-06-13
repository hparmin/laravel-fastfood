@extends('panel.layout.master')
@section('title','تنظیمات فوتر')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h4 class="fw-bold">تنظیمات فوتر</h4>
    </div>
    <form action="{{ route('footer.update',['footer' => $footer_settings->id ]) }}" class="row gy-4" method="post">
        @csrf
        @method('PUT')
        <div class="col-md-3">
            <label class="form-label">آدرس تماس با ما</label>
            <input value="{{ $footer_settings->contact_address }}" name="contact_address" type="text"
                   class="form-control">
            @error('contact_address')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">شماره تلفن تماس با ما</label>
            <input value="{{ $footer_settings->contact_phone }}" name="contact_phone" type="text" class="form-control">
            @error('contact_phone')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">ایمیل تماس با ما</label>
            <input value="{{ $footer_settings->contact_email }}" name="contact_email" type="text" class="form-control">
            @error('contact_email')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">عنوان</label>
            <input value="{{ $footer_settings->title }}" name="title" type="text" class="form-control">
            @error('title')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">متن</label>
            <input value="{{ $footer_settings->body }}" name="body" type="text" class="form-control">
            @error('body')
            <div class="form-text text-danger">{{ 'این فیلد الزامی میباشد.' }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">روز های کاری</label>
            <input value="{{ $footer_settings->work_days }}" name="work_days" type="text" class="form-control">
            @error('work_days')
            <div class="form-text text-danger">{{ 'این فیلد الزامی میباشد.' }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">ساعت شروع روز کاری</label>
            <input value="{{ $footer_settings->work_hour_from }}" name="work_hour_from" type="text"
                   class="form-control">
            @error('work_hour_from')
            <div class="form-text text-danger">{{ 'این فیلد الزامی میباشد.' }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">ساعت پایان روز کاری</label>
            <input value="{{ $footer_settings->work_hour_to }}" name="work_hour_to" type="text" class="form-control">
            @error('work_hour_to')
            <div class="form-text text-danger">{{ 'این فیلد الزامی میباشد.' }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک تلگرام</label>
            <input value="{{ $footer_settings->telegram_link }}" name="telegram_link" type="text" class="form-control">
            @error('telegram_link')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک اینستاگرام</label>
            <input value="{{ $footer_settings->instagram_link }}" name="instagram_link" type="text"
                   class="form-control">
            @error('instagram_link')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک واتس آپ</label>
            <input value="{{ $footer_settings->whatsapp_link }}" name="whatsapp_link" type="text" class="form-control">
            @error('whatsapp_link')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">لینک یوتیوب</label>
            <input value="{{ $footer_settings->youtube_link }}" name="youtube_link" type="text" class="form-control">
            @error('youtube_link')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">متن کپی رایت</label>
            <input value="{{ $footer_settings->copyright }}" name="copyright" type="text" class="form-control">
            @error('copyright')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-outline-primary mt-3">
                ثبت تغییرات
            </button>
        </div>
    </form>

@endsection()
