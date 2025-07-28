<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessEmails;
use App\Models\Admin;
use App\Models\AdminPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request as IlluminateRequest; // Add this lin



class LoginController extends Controller
{
    public function login()
    {
        if (\auth()->check()) {
            $user = Auth::guard('admin')->user();
            if($user->role == 2){
                $firstPermission = AdminPermission::where('admin_id', $user->id)->first();
               return redirect('admin/' . $firstPermission->permissions);

            }
            else{
                return redirect('admin/dashboard');

            }
        }
        return view('admin.auth.login');
    }

    public function authenticate(Request $r)
    {
        if (Auth::guard('admin')->attempt(['email' => strtolower($r->email), 'password' => $r->password])) {
            $user = Auth::guard('admin')->user();

            // Update the user's IP address
            $user->update(['last_login_ip' => IlluminateRequest::ip()]);

            if ($user->status == 0) {
                Auth::guard('admin')->logout();
                return ajaxResponse(100, 'Sorry, Your account is inactivated by admin. Please contact support.');
            }
            // Auth::guard('admin')->login($user);

            // if (env('APP_ENV') != 'production') {
            //     $otp_code = 1234;
            // } else {
            //     $otp_code = generateRandomNumber(4);
            // }

            $user_id = $user->id;
            // $minute = env('ADMIN_OTP_VALID_MIN');
            // $otp_valid_date = now()->addMinutes($minute);

            // Admin::where('id', $user->id)->update(['otp_valid_date' => $otp_valid_date, 'otp_code' => $otp_code]);

            // $emaildata = [
            //     'email_slug' => 'send-verification-code-mail',
            //     'NAME' => $user->name,
            //     'APP_NAME' => env('APP_NAME'),
            //     'OTP' => $otp_code,
            // ];

            // ProcessEmails::dispatch("emails.emaildynamic", $emaildata, $user->email, "", "")->onConnection('database')->onQueue('deliveryapp_emails');

            // Auth::guard('admin')->logout();
            // Session::flush();
            // Session::put('admin_otp', 1);
            $firstPermission = null;
            if($user->role === 2){
                $firstPermission = AdminPermission::where('admin_id', $user->id)->first();
                $firstPermission = $firstPermission->permissions;
             

            }

            return ajaxResponse(200, ['user_id' => base64Encode($user_id), 'segment' => $firstPermission]);
        } else {
            return ajaxResponse(100, trans('messages.error.invalid_email_password'));
        }
    }

    public function verification(Request $request)
    {
        $param['user_id'] = $request->id ? base64Decode($request->id) : '';
        if ($param['user_id'] == '') {
            return redirect('/');
        }
        return view('admin.auth.verification', $param);
    }

    public function verifyVerificationCode(Request $request)
    {
        if (Session::has('admin_otp') && Session::get('admin_otp') == 1) {
            $check_otp = Admin::where('otp_code', $request->otp_code)->first();
            if ($check_otp) {
                $current_time = date('Y-m-d H:i:s');
                if ($current_time > $check_otp->otp_valid_date) {
                    return ajaxResponse(100, trans('messages.error.verification_code_expired'));
                } else {
                    Session::put('UserTimeZone', $request->timezone);
                    Auth::guard('admin')->login($check_otp);
                    $check_otp->otp_code = null;
                    $check_otp->save();
                    return ajaxResponse(200, trans('messages.success.verification_code_send'));
                }
            } else {
                return ajaxResponse(100, trans('messages.error.invalid_code'));
            }
        } else {
            return ajaxResponse(100, trans('messages.error.request_timeout'));
        }
    }

    public function resendVerificationCode(Request $request)
    {
        $user_id = $request->user_id;
        if ($user_id) {
            $user = Admin::where('id', $user_id)->first();
          
            if (env('APP_ENV') != 'production') {
                $otp_code = 1234;
            } else {
                $otp_code = generateRandomNumber(4);
            }
            $minute = env('ADMIN_OTP_VALID_MIN');
            $otp_valid_date = Carbon::now()->addMinutes($minute);
            Admin::where('id', $user->id)->update(['otp_valid_date' => $otp_valid_date, 'otp_code' => $otp_code]);
            
            $emaildata = [
                'email_slug' => 'send-verification-code-mail',
                'NAME' => $user->name,
                'APP_NAME' => env('APP_NAME'),
                'OTP' => $otp_code,
            ];
          $ffhfh =  ProcessEmails::dispatch("emails.emaildynamic", $emaildata, $user->email, "", "")->onQueue('deliveryapp_emails');

           
            auth()->logout();
            Session::flush();
            Session::put('admin_otp', 1);
            Session::put('admin_id', $user_id);
            return ajaxResponse(200, $ffhfh, trans('messages.success.verification_code_resend'));
        }
        return ajaxResponse(100, 'Something went wrong. Try again latter.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
