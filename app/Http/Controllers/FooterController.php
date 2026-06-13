<?php

namespace App\Http\Controllers;

use App\Models\footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footer_settings = footer::first();
        return view('panel.footer.index', compact('footer_settings'));
    }
    public function edit()
    {
        $footer_settings = footer::first();
        return view('panel.footer.edit', compact('footer_settings'));
    }
    public function update(Request $request,footer $footer)
    {
        $request->validate([
            'contact_address' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'work_days' => 'required|string',
            'work_hour_from' => 'required|string',
            'work_hour_to' => 'required|string',
            'copyright' => 'required|string'
        ]);
        $footer->update([
            'contact_address' => $request->contact_address,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'title' => $request->title,
            'body' => $request->body,
            'work_days' => $request->work_days,
            'work_hour_from' => $request->work_hour_from,
            'work_hour_to' => $request->work_hour_to,
            'copyright' => $request->copyright,
            'telegram_link' => $request->telegram_link,
            'whatsapp_link' => $request->whatsapp_link,
            'instagram_link' => $request->instagram_link,
            'youtube_link' => $request->youtube_link,
        ]);
        return redirect()->route('footer.index')->with('success','فوتر با موفقیت آپدیت شد');
    }
}
