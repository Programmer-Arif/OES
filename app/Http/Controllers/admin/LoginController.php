<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')->with('error','Either email or password is incorrect');
            }
        } else {
            return redirect()->route('admin.login')
            ->withInput()
            ->withErrors($validator);
        }
    }

    // This method will show register page
    public function register() {
        return view('admin.register');
    }

    public function processRegister(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:2',
            'email' => 'string|required|email|unique:users|max:100',
            'password' => 'string|required|confirmed|min:6',
            'password_confirmation' => 'string|required',
        ]);

        if($validator->passes()){
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->save();
            return redirect()->route('admin.login')->with('success','You have successfully registered');
        } else {
            return redirect()->route('admin.register')
            ->withInput()
            ->withErrors($validator);
        }
    }

    

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
