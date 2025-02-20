<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emailverification;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    


    // This method will show login page of customer
    public function index() {
        return view('login');
    }

    // This method will authenticate user
    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect()->route('account.dashboard');
            } else {
                return redirect()->route('account.login')->with('error','Either email or password is incorrect');
            }
        } else {
            return redirect()->route('account.login')
            ->withInput()
            ->withErrors($validator);
        }
    }

    // This method will show register page
    public function register() {
        return view('register');
    }

    public function processRegister(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:2',
            'email' => 'string|required|email|unique:users|max:100',
            'password' => 'string|required|confirmed|min:6',
            'password_confirmation' => 'string|required',
        ]);

        if($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            // return redirect()->route('account.login')->with('success','You have successfully registered');
            Auth::login($user);
            return redirect()->route('account.verify');
        } else {
            return redirect()->route('account.register')
            ->withInput()
            ->withErrors($validator);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function sendOtp($user)
    {
        $otp = rand(100000,999999);
        $time = time();

        Emailverification::updateOrCreate(
            ['email' => $user->email],
            [
            'otp' => $otp,
            'created_at' => $time
            ]
        );

        $data['email'] = $user->email;
        $data['title'] = 'Mail Verification';

        $data['body'] = 'Your OTP is:- '.$otp;
        try{
            Mail::send('sendVerification',['data'=>$data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });
        }catch(\Exception $e){
            if($user->is_verified==0){
                $user->delete();
                Emailverification::where('email',$user->email)->delete();
            }
            return redirect()->route('account.login')->with('error','Failed to send message');
        }
    }

    public function verification()
    {
        if(Auth::user()->is_verified==1){
            return redirect()->route('account.dashboard');
        }
        else {
            $email = Auth::user()->email;
            $this->sendOtp(Auth::user());//OTP SEND
            return view('verification',compact('email'));
        }
    }

    public function verifiedOtp(Request $request)
    {
        if(Auth::user()->email!=$request->email){
            return response()->json(['success' => false,'msg'=> 'Credential Mismatch']);
        }
        $user = User::where('email',$request->email)->first();
        $otpData = Emailverification::where('email',$request->email)->where('otp',$request->otp)->first();
        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
        }
        else{

            $currentTime = time();
            $time = $otpData->created_at;

            if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
                User::where('id',$user->id)->update([
                    'is_verified' => 1
                ]);
                return response()->json(['success' => true,'msg'=> 'Mail has been verified']);
            }
            else{
                return response()->json(['success' => false,'msg'=> 'Your OTP has been Expired']);
            }

        }
    }

    public function resendOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = Emailverification::where('email',$request->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
            return response()->json(['success' => false,'msg'=> 'Please try after some time']);
        }
        else{

            $this->sendOtp($user);//OTP SEND
            return response()->json(['success' => true,'msg'=> 'OTP has been sent']);
        }

    }

    public function forgotPassword() {
        return view('forgotpassword');
    }
    public function forgotVerification(Request $request) {
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return redirect()->route('account.register')->with('error','The email doesn not exist in our records! Register Yourself.');
        }
        else {
            $email = $request->email;
            $this->sendOtp($user);//OTP SEND
            return view('forgot-verification',compact('email'));
        }
    }
    public function forgotVerifiedOtp(Request $request) {
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response()->json(['success' => false,'msg'=> 'Credential Mismatch']);
        }
        $otpData = Emailverification::where('email',$request->email)->where('otp',$request->otp)->first();
        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
        }
        else{
            $currentTime = time();
            $time = $otpData->created_at;

            if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
                Auth::login($user);
                return response()->json(['success' => true,'msg'=> 'Mail has been verified']);
            }
            else{
                return response()->json(['success' => false,'msg'=> 'Your OTP has been Expired']);
            }

        }
    }
    public function forgotResendOtp(Request $request) {
        $user = User::where('email',$request->email)->first();
        $otpData = Emailverification::where('email',$request->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
            return response()->json(['success' => false,'msg'=> 'Please try after some time']);
        }
        else{
            $this->sendOtp($user);//OTP SEND
            return response()->json(['success' => true,'msg'=> 'OTP has been sent']);
        }
    }

    public function resetPassword() {
        return view('resetpassword');
    }

    public function processResetPassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'password' => 'string|required|confirmed|min:6',
            'password_confirmation' => 'string|required',
        ]);

        if($validator->passes()){
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('account.dashboard');
        } else {
            return redirect()->route('account.resetpassword')
            ->withInput()
            ->withErrors($validator);
        }
    }

    
}
