<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('pegawai', [
            'pegawai' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email'],
            'phone' => ['required'],
            'jabatan' => ['required'],
            'division' => ['required'],
        ]);
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'jabatan' => $request->input('jabatan'),
            'division' => $request->input('division'),
            'password' => Hash::make('password')
        ]);

        return Redirect::route('pegawai');
    }

    public function edit() {}
}
