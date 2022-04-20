<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    public function list()
    {

        return view('users.list', [
            'users' => User::all()
        ]);
    }

    public function addForm()
    {

        return view('users.add');
    }

    public function add()
    {

        $attributes = request()->validate([
            'first' => 'required',
            'last' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'about' => 'nullable'
        ]);

        $user = new User();
        $user->first = $attributes['first'];
        $user->last = $attributes['last'];
        $user->email = $attributes['email'];
        $user->password = $attributes['password'];
        $user->about = $attributes['about'];
        $user->save();

        return redirect('/console/users/list')
            ->with('message', 'User has been added!');
    }

    public function editForm(User $user)
    {

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {

        $attributes = request()->validate([
            'first' => 'required',
            'last' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable',
            'about' => 'nullable'
        ]);

        $user->first = $attributes['first'];
        $user->last = $attributes['last'];
        $user->email = $attributes['email'];
        $user->about = $attributes['about'];

        if ($attributes['password']) $user->password = $attributes['password'];

        $user->save();

        return redirect('/console/users/list')
            ->with('message', 'User has been edited!');
    }

    public function photoForm(User $user)
    {
        return view('users.photo', [
            'user' => $user,
        ]);
    }

    public function photo(User $user)
    {

        $attributes = request()->validate([
            'photo' => 'required|image',
        ]);

        Storage::delete($user->photo);

        $path = request()->file('photo')->store('users');

        $user->photo = $path;
        $user->save();

        return redirect('/console/users/list')
            ->with('message', 'User photo has been edited!');
    }

    public function delete(User $user)
    {

        if ($user->id == auth()->user()->id) {
            return redirect('/console/users/list')
                ->with('message', 'Cannot delete your own user account!');
        }

        $user->delete();

        return redirect('/console/users/list')
            ->with('message', 'User has been deleted!');
    }

    
    // API -> GET: api/users/{userId}
    public function getAll($userId)
    {
        return User::where('id', '=', $userId)->get();
    }
}
