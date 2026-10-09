<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Show the form for creating a new resource.
     */
    public function register_index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login_proces(Request $request)
    {
        $credential = $request->validate->only([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credential)){
            $request->session()->regenerate();
            return redirect()
                ->intended()
                ->with('success', 'Selamat Datang Kembali'. Auth::user()->name);
        }
        return back()->withErrors([
            'name' => 'Username Atau Password Salah'
        ])
        ->onlyInput('name');
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
