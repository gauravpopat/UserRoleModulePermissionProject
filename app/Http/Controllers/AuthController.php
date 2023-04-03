<?php

namespace App\Http\Controllers;

use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordResetToken;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{

    //Create User
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'                  => 'required|max:50',
            'email'                 => 'required|email|max:50|unique:users,email',
            'password'              => 'required|min:8|max:15|confirmed',
            'password_confirmation' => 'required',
            'role_id'               => 'required|array|exists:roles,id'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $user = User::create($request->only(['name', 'email', 'is_admin']) + [
            'password'                  => Hash::make($request->password),
            'email_verification_code'   => Str::random(22)
        ]);

        $user->roles()->attach($request->role_id);

        // Welcome Notification with Email Verification Link.
        $user->notify(new WelcomeNotification($user));

        return ok('User Created Successfully and Sent Email Verification Mail.', $user);
    }

    public function verifyEmail($verification_code)
    {
        $user = User::where('email_verification_code', $verification_code)->first();

        if (!$user) {
            return error('Token Expired');
        }

        $user->update([
            'is_verified'               => true,
            'email_verified_at'         => now(),
            'email_verification_code'   => null // code null after verification.
        ]);

        return ok('Email Verified Successfully');
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'     => 'required|email|exists:users,email',
            'password'  => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $user = User::where('email', $request->email)->first();

        if ($user->is_verified == true) {

            if (Auth::attempt(['email'   =>  $request->email, 'password'   =>  $request->password])) {
                $token = $user->createToken("API Login Token")->plainTextToken; // generated token (sanctum)
                return ok('Login Successfully', $token);
            } else {
                return error('Incorrect Password!');
            }
        } else {
            return error('Email not verified!'); // is_verified false
        }
    }

    public function forgotPasswordLink(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $user = User::where('email', $request->email)->first();
        $token = Str::random(64);

        PasswordResetToken::updateOrCreate(
            ['email'         => $request->email],
            [
                'token'         => $token,
                'created_at'    => now(),
                'expired_at'    => Carbon::now()->addDays(2)
            ]
        );

        $user['token']  = $token;

        //Notification for resetting password.
        $user->notify(new ResetPasswordNotification($user));

        return ok('Mail Sent for Reset Passoword!');
    }

    public function resetPassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'                 => 'required|email|exists:password_reset_tokens,email|exists:users,email',
            'token'                 => 'required|exists:password_reset_tokens,token',
            'password'              => 'required|min:8|max:15|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $passwordReset = PasswordResetToken::where('token', $request->token)->first();
        if ($passwordReset->expired_at > Carbon::now()) { // if token is not expired
            $user = User::where('email', $passwordReset->email)->first();
            $user->update([
                'password'  =>  Hash::make($request->password)
            ]);
            $passwordReset->delete(); // delete that token record
            return ok('Password Changed Successfully');
        } else {
            return error('Token Expired'); // if expired_date < now()
        }
    }
}
