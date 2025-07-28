<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessEmails;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetPasswordLink(Request $request)
    {
        $email = $request->email;
        PasswordReset::where('email', $email)->delete();
        $user = \App\Models\Admin::where('email', $email)->first();
        if ($user) {
            $token = Str::random(60);

            $passwordReset = new \App\Models\PasswordReset();
            $passwordReset->email = $email;
            $passwordReset->token = bcrypt($token);
            $passwordReset->save();

            /* Mail send to customer start */
          
            $url = route('password_reset', ['token' => $token]);
   


            $emaildata = array('name' => $user->name, 'token' => $token,  'email' => urlencode($email), 'email_slug' => 'forgot-password', 'APP_NAME' => 'PIIKUP', 'url' => $url, 'APP_URL' => env('APP_URL'));

            $subject = "";
            $path = 'emails.emaildynamic';
            $reply_to = "";
            \App\Jobs\ProcessEmails::dispatch($path, $emaildata, $email, $subject, $reply_to)->onConnection('database')->onQueue('default');
            return ajaxResponse(200, trans('messages.success.reset_password_link_send'));
        } else {
            return ajaxResponse(100, trans('messages.error.email_not_exist'));
        }
    }
}
