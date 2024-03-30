<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Title;
use Illuminate\Http\Request;

class Usercontroller extends Controller {
    
    public function index() {
        $users = User::with('title')->get();

        return view('homepage', ['users' => $users]);
    }

    public function addUser(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
            'avatar' => 'nullable',
            'title_id' => 'required',
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('public/avatars');
            $validatedData['avatar'] = basename($avatarPath);
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = new User($validatedData);
        $user->save();


        return redirect()->route('home')->with('success', 'User added successfully!');
    }

    public function showAddPage() {
        $titles = Title::all();
        return view('addpage', compact('titles'));
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('home')->with('success', 'Delete User successfully!');
    }

    public function editUser($id)   {
        $user = User::findOrFail($id);
        $titles = Title::all();

        return view('editpage', compact('user', 'titles'));
    }

    public function updateUser(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required' . $id,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable',
            'title_id' => 'required',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('public/avatars');
            $validatedData['avatar'] = basename($avatarPath);
        }

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        if ($request->isMethod('PUT')) {

            $user->update($validatedData);
            return redirect()->route('home')->with('success', 'User updated successfully!');
        }
    }
}
