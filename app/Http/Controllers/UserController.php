<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index()
    {
        $user = User::paginate(10);
        return view('users.index',[
            'user' => $user
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');
        User::create($data);

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return view('users.edit',[
            'item' => $user
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();
        if ($request->file('profile_photo_path')) {
            $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');
        }
        $user->update($data);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
