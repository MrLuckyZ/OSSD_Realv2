<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // Add this line
use Illuminate\Support\Str;
use App\Models\User;

class ForgetPasswordController extends Controller
{
    // Forget Password Form View
    public function ForgetPassword()
    {
        return view('auth.forgot_password');
    }

    // Handle Forget Password Form Submission
    public function ForgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => "required|email|exists:users",
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Store email in session
        Session::put('reset_email', $request->email);

        Mail::send("emails.email-forget-password", ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject("Reset Password");
        });

        return redirect()->route("ForgetPassword")->with('success', 'Reset password link has been sent to your email.');
    }

    // Reset Password Form View
    public function ResetPassword($token)
    {
        // Retrieve email from session
        $email = Session::get('reset_email');
        return view("new-password", compact('token', 'email'));
    }

    // Handle Reset Password Form Submission
    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users",
            "password" => "required|string|confirmed",
            "password_confirmation" => "required"
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                "email" => $request->email,
                "token" =>  $request->token,
            ])->first();

        if (!$updatePassword) {
            return redirect()->route('reset.password')->with('error', 'Invalid');
        }

        User::where("email", $request->email)
            ->update(["password" => Hash::make($request->password)]);

        DB::table("password_reset_tokens")->where(["email" => $request->email])->delete();
        return redirect()->route("login")->with("success", "Password reset successfully");
        
    }
}
