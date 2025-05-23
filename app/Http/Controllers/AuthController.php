<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function showUserLoginForm()
    {
        return view('auth.login_user');
    }
    
    public function showAdminLoginForm()
    {
        return view('auth.login_admin');
    }

    public function loginUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal :min karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
    
            // Cek apakah user adalah admin
            if (Auth::user()->role !== 'user') {
                Auth::logout(); // Logout jika bukan admin
                return back()->with('error', 'Anda tidak memiliki akses sebagai user.');
            }
    
            return redirect()->intended('home')->with('success', 'Login berhasil!');
        }
        return back()->withErrors(['email' => 'Email atau password salah.',])->withInput();
    }

    public function loginAdmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal :min karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
    
            // Cek apakah user adalah admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout(); // Logout jika bukan admin
                return back()->with('error', 'Anda tidak memiliki akses sebagai admin.');
            }
    
            return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
        }
        return back()->withErrors(['email' => 'Email atau password salah.',])->withInput();
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User',
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        // Simpan role sebelum logout
        $role = Auth::user()->role;

        // Proses logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect sesuai role
        if ($role === 'admin') {
            return redirect()->route('admin.login')->with('success', 'Anda telah berhasil logout.');
        } else {
            return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
        }
    }


    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function forgotPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Form email harus diisi',
            'email.exists' => 'Email yang Anda masukan belum terdaftar'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
        } else {
            return back()->with('error', 'Gagal mengirim link reset password. Silakan coba lagi.');
        }
    }

    public function resetPassword($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

    public function resetPasswordForm(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ],[
            'password.required' => 'Form ini harus diisi',
            'password.min' => 'Password harus terdiri dari minimal :min karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        if ($status === Password::PASSWORD_RESET) {
            return back()->with('success', 'Password Anda telah berhasil direset. Silakan gunakan password baru Anda untuk login.');
        } else {
            return back()->with('error', 'Gagal mereset password. Silakan coba lagi.');
        }
    }
}
