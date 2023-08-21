<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function profile(User $user)
    {
        return view('user.profile', compact('user'));
    }

    public function editProfile(User $user)
    {
        // Перевірка авторизації
        if (Auth::user()->id !== $user->id) {
            return abort(403);
        }

        return view('user.edit', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {
        // Перевірка авторизації
        if (Auth::user()->id !== $user->id) {
            return abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('user.profile', $user)->with('success', 'Profile updated successfully.');
    }
}
