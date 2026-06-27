<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;
use Illuminate\Support\Str;


use Ghasedaksms\GhasedaksmsLaravel\GhasedaksmsFacade;
use Ghasedak\DataTransferObjects\Request\OtpMessageDTO;
use Ghasedak\DataTransferObjects\Request\ReceptorDTO;
use Ghasedak\DataTransferObjects\Request\InputDTO;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('app.login.login_form');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cellphone' => ['required', 'regex:/^09[0-9]{9}$/']
        ]);

        try {
            $user = User::where('cellphone', $request->cellphone)->first();

            $otp = mt_rand(100000, 999999);
            $loginToken = Str::random(80);

            if ($user) {
                $user->update([
                    'otp' => $otp,
                    'login_token' => $loginToken,
                ]);
            } else {
                $user = User::create([
                    'cellphone' => $request->cellphone,
                    'otp' => $otp,
                    'login_token' => $loginToken,
                ]);
            }

//            $response = GhasedaksmsFacade::sendOtp(new OtpMessageDTO(
//                sendDate: Carbon::now(),
//                receptors: [new ReceptorDTO(
//                    mobile: $request->cellphone,
//                    clientReferenceId: 'ref-' . $user->id,
//                )],
//                templateName: 'laravel',
//                inputs: [new InputDTO(param: 'code', value: $otp)],
//            ));

            return response()->json([
                'message' => 'کد ورود ارسال شد.',
                'login_token' => $loginToken,
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'خطا در ارسال کد ورود.',
                'error' => $ex->getMessage(),
            ], 500);
        }
    }


    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'integer', 'digits:6'],
            'login_token' => ['required']
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->first();

            if (! $user) {
                return response()->json([
                    'message' => 'درخواست ورود نامعتبر است.'
                ], 404);
            }

            if ($user->otp != $request->otp) {
                return response()->json([
                    'message' => 'کد ورود نادرست است.'
                ], 422);
            }

            auth()->login($user, true);

            $user->update([
                'otp' => null,
                'login_token' => null,
            ]);

            return response()->json([
                'message' => 'ورود با موفقیت انجام شد.'
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'خطا در بررسی کد ورود.',
                'error' => $ex->getMessage(),
            ], 500);
        }
    }


    public function resendOtp(Request $request)
    {
        $request->validate([
            'login_token' => ['required']
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->first();

            if (! $user) {
                return response()->json([
                    'message' => 'درخواست نامعتبر است. لطفا دوباره تلاش کنید.'
                ], 404);
            }

            $otp = mt_rand(100000, 999999);

//            $loginToken = Hash::make(Str::random(40));
            $loginToken = Str::random(80);

            $user->update([
                'otp' => $otp,
                'login_token' => $loginToken,
            ]);

            $response = GhasedaksmsFacade::sendOtp(new OtpMessageDTO(
                sendDate: Carbon::now(),
                receptors: [new ReceptorDTO(
                    mobile: $user->cellphone,
                    clientReferenceId: 'ref-' . $user->id,
                )],
                templateName: 'laravel',
                inputs: [new InputDTO(param: 'code', value: $otp)],
            ));

            return response()->json([
                'message' => 'کد ورود مجددا ارسال شد.',
                'login_token' => $loginToken,
            ], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'خطا در ارسال مجدد کد ورود.',
                'error' => $ex->getMessage(),
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
