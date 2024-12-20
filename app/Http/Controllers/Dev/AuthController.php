<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function forgotPassword()
    {
        return view('auth.passwords.reset');
    }

    public function signup()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'unique:users,username|required',
            'phone_number' => 'unique:users,phone_number|required|min:18|max:19',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'confirm-password');
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            // RoleUser::create(['user_id' => $user->id, 'role_id' => 1]);
            $response = ['message' => 'User berhasil di buat', 'button' => 'Login'];
            $code = 200;
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $code = 422;
            $response = ['message' => 'User gagal di buat', 'button' => 'Coba Lagi'];
        }

        return response()->json($response, $code);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $response = ['status' => 'Gagal', 'button' => trans('translation.reload'), 'message' => 'kombinasi username dan password tidak terdaftar di aplikasi kita', 'button' => 'Coba lagi'];
        $code = 401;
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ], function (User $user) {
            return $user->valid;
        }, $request->has('remember_me'))) {
            $request->session()->regenerate();
            $response = ['status' => 'Berhasil', 'button' => trans('translation.signin'), 'message' => 'kombinasi username dan password ditemukan', 'button' => 'Masuk Aplikasi'];
            $code = 200;
        }

        return response()->json($response, $code);
    }

    public function executeResetPassword(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|min:18|max:19|exists:users,phone_number',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
        ]);
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->setRememberToken(null);
        Auth::logout();
        $request->session()->flush();
        $request->session()->invalidate();

        return redirect()->route('login');
    }
}
