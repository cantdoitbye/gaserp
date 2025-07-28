<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    public function index(Request $request)
    {
        $param['token'] = $request->token ? $request->token : '';
        return view('admin.auth.reset-password', $param);
    }

    public function passwordUpdate(Request $request)
    {
        $token = $request->token;
        $user = User::where('forgot_token', $token)->first();
        if ($user) {
            $new_password = $request->password;
            $npswd = bcrypt($new_password);
            User::where('id', $user->id)->update(['password' => $npswd, 'forgot_token' => NULL]);
            Session::flash('success', trans('messages.success.update_password'));
            if ($user->role == 1) {
                return ajaxResponse(200);
            }
            return ajaxResponse(201);
        } else {
            return ajaxResponse(100, trans('messages.error.reset_password_link_expired'));
        }
    }
}
