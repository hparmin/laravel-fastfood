<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(20);;
        return view('panel.coupon.index',compact('coupons'));
    }
    public function create()
    {
        return view('panel.coupon.create');
    }
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'percentage' => 'required|integer|max:100',
            'expired_at' => 'required|date_format:Y/m/d H:i:s'
        ]);
        coupon::create([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => getMiladiDate($request->expired_at),
        ]);
        return redirect()->route('coupon.index')->with('success','کوپن تخفیف با موفقیت ایجاد شد');
    }
    public function trash()
    {
        $trashed_coupons = Coupon::onlyTrashed()->latest('deleted_at')->paginate(20);
        return view('panel.coupon.trashed', compact('trashed_coupons'));
    }
    public function recovery($coupon_id)
    {
        $coupon = Coupon::withTrashed()->find($coupon_id);
        $coupon->restore();
        return redirect()->route('coupon.trash')->with('success', 'کوپن یازیابی شد.');
    }
    public function hard_delete($coupon_id)
    {
        $coupon = Coupon::withTrashed()->find($coupon_id);
        $coupon->forceDelete();
        return redirect()->route('coupon.trash')->with('warning', 'کوپن به طور کامل حذف شد.');
    }
    public function update(Request $request, coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,'.$coupon->id,
            'percentage' => 'required|integer|max:100',
            'expired_at' => 'required|date_format:Y/m/d H:i:s'
        ]);
        $coupon->update([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => getMiladiDate($request->expired_at),
        ]);
        return redirect()->back()->with('success','کد تخفیف با موفقیت بروز رسانی شد');
    }
    public function edit(coupon $coupon)
    {
        return view('panel.coupon.edit',compact('coupon'));
    }
    public function destroy(coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('warning','کد تخفیف با موفقیت حذف شد');
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);
        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon){
            return redirect()->back()->with(['warning'=>'کد تخفیف یافت نشد']);
        }
        if ($coupon->expired_at < Carbon::now('Asia/Tehran')){
            return redirect()->back()->with(['warning' => "کد تخفیف $request->code منقضی شده است."]);
        }
        $request->session()->put('coupon',['code'=>$coupon->code,'percent'=>$coupon->percentage]);
        return redirect()->back()->with(['success' => 'کد تخفیف با موفقیت اعمال شد.']);
    }

    public function destroySession(Request $request)
    {
        $request->session()->remove('coupon');
        return redirect()->back();
    }
    public function userdestroySession(Request $request)
    {
        $request->session()->remove('coupon');
        return redirect()->back()->with(['warning'=>'کد تخفیف حذف شد.']);
    }
}
