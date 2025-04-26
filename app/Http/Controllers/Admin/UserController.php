<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        /**
         * Mengambil daftar pengguna yang dipaginasi berdasarkan filter email dan username.
         *
         * Metode ini melakukan query pada model `User` untuk mencari pengguna
         * yang alamat email atau username-nya mengandung kata kunci pencarian yang diberikan
         * dalam permintaan. Hasilnya dipaginasi dengan batas 25 pengguna per halaman.
         */
        $users = User::where(function ($query) use ($request) {
            $query->where('email', 'like', '%' . $request->search . '%')
              ->orWhere('username', 'like', '%' . $request->search . '%');
        })->paginate(25);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(User $user)
    {

        return view('admin.users.edit', compact('user'));
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email,' . $user->id_user . ',id_user'],
            'password' => 'nullable|confirmed',
        ]);

        if ($request->input('password')) {
            $user->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $user->update([
                'email' => $request->email,
            ]);
        }
    
    return redirect()->route('users.index');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required|confirmed',
        ]);

        User::create($validated);

        return redirect()->route('users.index');
    }
}
