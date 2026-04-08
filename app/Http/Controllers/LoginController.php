<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authenticate(Request $request){
    
        $response = ['success' => false, 'msg' => 'Ada kesalahan, harap coba lagi'];

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response['success'] = false;
            $response['msg'] = $validator->messages();
            return response()->json($response);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // try login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // save last login
            User::where('email', $request->email)->update(['last_login_at' => Carbon::now()->format('Y-m-d')]);

            // return to dashboard
            $response['success'] = true;
            $response['msg'] = 'Login berhasil';
            return response()->json($response);
        }

        $response['success'] = false;
        $response['msg'] = 'Login Gagal, harap periksa email dan password';
        return response()->json($response);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
