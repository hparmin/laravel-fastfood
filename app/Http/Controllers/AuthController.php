<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;


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
            'cellphone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/']
        ]);
        $user = User::where('cellphone', $request->cellphone)->first();
        $otp = mt_rand(100000, 999999);
        $loginToken = Hash::make('cecQRV@@5$GAFS65@4VARTsaf**@gdsf');

        try {
            if ($user) {
                $user->update([
                    'otp' => $otp,
                    'login_token' => $loginToken,
                ]);
            } else {
                $user = user::create([
                    'cellphone' => $request->cellphone,
                    'otp' => $otp,
                    'login_token' => $loginToken,
                ]);
            }


//           connect to Ghasedaksms:
//            $response = GhasedaksmsFacade::sendOtp(new OtpMessageDTO(
//                sendDate: Carbon::now(),
//                receptors: [new ReceptorDTO(
//                    mobile: $request->cellphone,
//                    clientReferenceId: 'ref-1',
////                    clientReferenceId: '$user'
//                )],
//                templateName: 'laravel', // نام قالب در پنل
//                inputs: [new InputDTO(param: 'code', value: $otp)],
//            ));

            return response()->json(['login_token' => $loginToken,
//                'response' => $response
            ],
                200);

        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|int|digits:6',
            'login_token' => 'required'
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->first();
            if ($user) {
                if ($user->otp == $request->otp) {
                    auth()->login($user, $remember = true);
                    return response()->json(['message' => 'ورود با موفقیت انجام شد.'], 200);
                } else {
                    return response()->json(['message' => 'کد وورد نادرست است.'], 422);
                    // wrong otp code
                }
            }
        } catch (\Exception $ex) {

        }

    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'login_token' => 'required'
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->first();
            $user_cellphone = $user->cellphone;
            $otp = $user->otp;
            $response = GhasedaksmsFacade::sendOtp(new OtpMessageDTO(
                sendDate: Carbon::now(),
                receptors: [new ReceptorDTO(
                    mobile: $user_cellphone,
                    clientReferenceId: 'ref-1',
//                    clientReferenceId: '$user'
                )],
                templateName: 'laravel', // نام قالب در پنل
                inputs: [new InputDTO(param: 'code', value: $otp)],
            ));
        } catch (\Exception $ex) {

        }

    }
}
