<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // LOGIN DAN REGISTER BLADE FORM
    public function ShowLoginForm()
    {
        return view('auth.login');
    }
    public function ShowRegisterForm()
    {
        return view('auth.register');
    }

    // FUNGSI LOGIN DAN REGISTER

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai admin!');
        }
        return redirect()->route('pegawai.profil.index')->with('success', 'Berhasil login sebagai pegawai!');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
}

    
    
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    

    public function logout() {
        Auth::logout();
        return redirect('/login')->with('succes','Berhasil Logout.');
    }

}
