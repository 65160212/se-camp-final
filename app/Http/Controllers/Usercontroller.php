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

    public function addUser(Request $req) {
        $validatedData = $req->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'avatar' => 'nullable',
            'title_id' => 'required',
        ]);

        

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = new User($validatedData);
        $user->save();


        return redirect()->route('home');
    }

    public function showAddPage() {
        $titles = Title::all();
        return view('addpage', compact('titles'));
    }

    public function deleteUser($index) {
        $user = User::findOrFail($index);
        $user->delete();

        return redirect()->route('home');
    }

    public function editUser($index)   {
        $user = User::findOrFail($index);
        $titles = Title::all();

        return view('editpage', compact('user', 'titles'));
    }

    public function updateUser(Request $req, $index) {
        $validatedData = $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $index,
            'password' => 'nullable',
            'avatar' => 'nullable',
            'title_id' => 'required',
        ]);

        $user = User::findOrFail($index);

        if ($req->hasFile('avatar')) {
            $Avatar = $req->file('avatar');
            $avatarPath = $Avatar->store('public/avatars');
            $validatedData['avatar'] = basename($avatarPath);
        }

        if ($req->isMethod('PUT')) {
            // Handle the PUT request
            $user->update($validatedData);
            return redirect()->route('home');
        }
    }
}