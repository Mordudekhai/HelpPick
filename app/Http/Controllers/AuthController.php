<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah');
        }

        // SIMPAN SESSION
        Session::put('admin', $user->id);
        Session::put('admin_name', $user->name);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Session::flush(); // hapus semua session
        return redirect('/'); // ke landing page
    }
}