<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserRole;
use App\Models\PasswordReset;
use App\Helpers\StaticFunction;
use Mail;
use Hash;

class AuthenticationController extends Controller
{
    protected $redirectTo = '/admin/dashboard';

    // Login Cover
    public function login_cover()
    {
        $pageConfigs = ['blankPage' => true];
        if(!Auth::check()){
            // return view('/content/authentication/auth-login-cover', ['pageConfigs' => $pageConfigs]);    
            return view('/content/authentication/auth-login-basic', ['pageConfigs' => $pageConfigs]);
        }
        return redirect()->route('dashboard');
    }

    // Forgot Password cover
    public function forgot_password_cover()
    {
        $pageConfigs = ['blankPage' => true];
        return view('/content/authentication/auth-forgot-password-basic', ['pageConfigs' => $pageConfigs]);
        // return view('/content/authentication/auth-forgot-password-cover', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password cover
    public function reset_password_cover(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ], [
            'email.required' => 'The email is required.',
        ]);
        $user = User::with('user_role')->where('email', $request->email)->first();
        if (empty($user)) {
            return redirect()->route('auth-forgot-password')->with('error', 'Entered email is not registered.');
        } else {
            // if ($user->user_role->role_id == 1 || $user->user_role->role_id == 2) {
            if ($user->user_role->role_id != 3) {
                PasswordReset::insert([
                    'email'      => $request->email,
                    'token'      => $request->_token,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $data = array(
                    'token' => $request->_token,
                    'role' => $user->user_role->role_id,
                    'email' => $user->email,
                    'name' => $user->name .($user->lname != null) ? ' '.$user->lname : "",
                );
                Mail::send('content.emails.reset-password-email', ['data' => $data], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });
                return redirect()->route('auth-forgot-password')->with('success', 'We have e-mailed your password reset link!');
            } else {
                return redirect()->route('auth-forgot-password')->with('error', 'Sorry, You are not user.');
            }
        }
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|exists:users,email,deleted_at,NULL',
            'password' => 'required',
        ]);
        $user = User::with('user_role')->where('email',$request->email)->first();
        if($user){
            if($user->status == 1)
            {
                if($user->user_role->role_id != 3){
                    if (Auth::attempt([
                        'email' => $request->email,
                        'password' => $request->password,
                        'status' => 1,
                    ], $request->has('remember'))) {
                        Auth::login($user);
                        return redirect()->route('dashboard')->with('success', $user->name.' Loggedin Successfully.');
                    } else {
                        return redirect()->route('auth-login')->with('error', 'Invalid Login.');
                    }
                }else{
                    if (Auth::attempt([
                        'email' => $request->email,
                        'password' => $request->password,
                        'status' => 1,
                    ], $request->has('remember'))) {
                        Auth::login($user);
                        return redirect()->route('user-dashboard')->with('success', $user->name.' Loggedin Successfully.');
                    } else {
                        return redirect()->route('auth-login')->with('error', 'Invalid Login.');
                    }
                    // return redirect()->route('auth-login')->with('error', 'Invalid Login.');
                }
            }else{
                return redirect()->route('auth-login')->with('error', 'Your account is not active, please contact to admin.');
            }
        }else{
            return redirect()->route('auth-login')->with('error', 'Invalid Login.');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('auth-login');
    }

    public function showResetForm($token) {
        $pageConfigs = ['blankPage' => true];
        // return view('/content/authentication/auth-reset-password-cover', ['pageConfigs' => $pageConfigs, 'token' => $token]);
        return view('/content/authentication/auth-reset-password-basic', ['pageConfigs' => $pageConfigs, 'token' => $token]);
    }

    public function resetPassword(Request $request) {
        $this->validate($request, [
            'password'         => 'required|string|min:6',
            'confirm_password' => 'required|required_with:password|same:password',
        ], [
            'confirm_password.required' => 'The confirm password field is required.',
        ]);
        $updatePassword = PasswordReset::where('token', $request->token)->first();
        if (!$updatePassword) {
            return redirect()->route('auth-reset-password', [$request->token])->with('error', 'Invalid token!');
        }
        $user = User::where('email', $updatePassword->email)->update([
            'password' => Hash::make($request->password),
        ]);
        PasswordReset::where(['email' => $updatePassword->email])->delete();
        return redirect()->route('auth-reset-password', [$request->token])->with('success', 'Your password has been changed!');
    }
}
