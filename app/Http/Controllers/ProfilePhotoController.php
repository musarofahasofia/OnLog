<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilePhotoController extends Controller
{
        public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return back()->with('message', 'Profil berhasil diperbarui.');
    }

}
