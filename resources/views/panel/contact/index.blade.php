@extends('panel.layout.master')
@section('title','پیام های تماس با ما')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5">
        <h4 class="fw-bold">پیام ها</h4>
    </div>
    <div class="table-responsive">
        <table class="table features align-middle">
            <thead>
            <tr>
                <th>نام</th>
                <th>ایمیل</th>
                <th>عنوان</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->subject }}</td>
                    <td class="d-flex">
                        <a href="{{ route('contact.show',['contact' => $message->id]) }}" class="btn btn-primary ms-1">نمایش</a>
                        <form action="{{ route('contact.destroy',['contact_us' => $message->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger ms-1" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
