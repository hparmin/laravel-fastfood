<form action="{{ route('contact.store') }}" method="post">
    @csrf
    <div>
        <div class="form-text text-danger">@error('name') {{ $message }} @enderror</div>
        <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="نام و نام خانوادگی"/>
    </div>
    <div>
        <div class="form-text text-danger">@error('email') {{ $message }} @enderror</div>
        <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="ایمیل"/>
    </div>
    <div>
        <div class="form-text text-danger">@error('subject') {{ $message }} @enderror</div>
        <input type="text" value="{{ old('subject') }}" name="subject" class="form-control" placeholder="موضوع پیام"/>
    </div>
    <div>
        <div class="form-text text-danger">@error('body') {{ $message }} @enderror</div>
        <textarea name="body" rows="10" style="height: 100px" class="form-control"
                  placeholder="متن پیام">{{old('body')}}</textarea>
    </div>
    <div class="btn_box">
        <button>
            ارسال پیام
        </button>
    </div>
</form>
