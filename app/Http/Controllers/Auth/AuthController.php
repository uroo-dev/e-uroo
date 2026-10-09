<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login_index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login_proces(Request $request)
    {
        $credential = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect()
                ->intended('/')
                ->with('success', 'Selamat Datang Kembali' . Auth::user()->name);
        }
        return back()->withErrors([
            'name' => 'Username Atau Password Salah'
        ])
            ->onlyInput('name');
    }

    /**
     * Show the form for registered a new user.
     */
    public function register_index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register_proces(Request $request)
    {
        $isAdmin = Auth::check() && Auth::user()->role == 'admin';

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'phone' => 'required',
            'avatar' => 'nullable|image',
        ]);

        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);

        if ($isAdmin) {
            return redirect()->back();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
