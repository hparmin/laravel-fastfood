<?php

namespace App\Http\Controllers;

use App\Models\contact_us;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('app.contact-us');
    }
    public function showall()
    {
        $messages = contact_us::all();
        return view('panel.contact.index',compact('messages'));
    }
    public function show(contact_us $contact_us)
    {
        return view('panel.contact.edit',compact('contact_us'));
    }
    public function destroy(contact_us $contact_us)
    {
        $contact_us->delete();
        return redirect()->back()->with('warning','پیام با موفقیت حذف شد');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);
        contact_us::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'body' => $request->body
        ]);
        return redirect()->back()->with('success','پیام شما با موفقیت ثبت شد.');
    }
}
