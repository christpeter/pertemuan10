<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Mengunggah data pengguna baru beserta foto
    public function upload(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = $request->file('photo')->store('photos', 'public');
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $filePath,
        ]);

        return redirect()->route('users.index')->with('success', 'Berhasil unggah foto');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Mengupdate data pengguna dan foto
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            $request->validate(['photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);
            $filePath = $request->file('photo')->store('photos', 'public');

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $filePath;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Berhasil mengubah foto');
    }

    // Menghapus foto pengguna
    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
            $user->photo = null;
            $user->save();
        }

        return redirect()->route('users.index')->with('success', 'Berhasil hapus foto');
    }
}
