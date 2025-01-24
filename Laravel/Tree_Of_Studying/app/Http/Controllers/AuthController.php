<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginPage()
{
    return view('login_page');
}
    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru' // Default role sebagai guru
        ]);

        return redirect()->route('login');
    }


    public function login()
    {
        return view('auth/login');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'account_type' => 'required|in:guru,murid,orang_tua', // Validasi tipe akun
        ]);

        // Autentikasi
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // Jika permintaan AJAX, kembalikan JSON error
            if ($request->ajax()) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            throw ValidationException::withMessages(['email' => trans('auth.failed')]);
        }

        // Regenerasi sesi setelah autentikasi berhasil
        $request->session()->regenerate();

        // Ambil pengguna yang berhasil login
        $user = Auth::user();

        // Cek apakah tipe akun yang dipilih cocok dengan role pengguna yang tersimpan
        if (($user->role === 'guru' && $request->account_type === 'guru') ||
            ($user->role === 'murid' && $request->account_type === 'murid') ||
            ($user->role === 'orang_tua' && $request->account_type === 'orang_tua')
        ) {
            // Jika permintaan AJAX, kembalikan JSON role pengguna
            if ($request->ajax()) {
                return response()->json(['role' => $user->role]);
            }

            // Redirect ke dashboard sesuai dengan role
            if ($user->role === 'guru') {
                return redirect()->route('guru.landing-brain');
            } elseif ($user->role === 'murid') {
                return redirect()->route('murid.dashboard');
            } elseif ($user->role === 'orang_tua') {
                return redirect()->route('orangtua.dashboard');
            }
        }

        // Jika tipe akun tidak cocok, logout dan kembalikan pesan error
        Auth::logout();

        if ($request->ajax()) {
            return response()->json(['error' => 'Tipe akun tidak sesuai dengan kredensial.'], 403);
        }

        return back()->withErrors(['account_type' => 'Tipe akun tidak sesuai dengan kredensial.']);
    }



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }


    public function dashboard()
    {
        $user = Auth::user(); // Ambil data user yang login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        return view('dashboard', compact('user')); // Kirim $user ke Blade
    }

    public function profile()
    {
        return view('profile');
    }
}
