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

    public function edit($id) {
        return Inertia::render('pegawai-edit', [
            'edited_user' => User::find($id),
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email'],
            'phone' => ['required'],
            'jabatan' => ['required'],
            'division' => ['required'],
        ]);
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->jabatan = $request->input('jabatan');
        $user->division = $request->input('division');
        $user->save();

        return Redirect::route('pegawai');
    }
}
