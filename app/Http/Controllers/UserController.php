<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->paginate(12);

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,lecturer',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole($data['role']);

        return back()->with('success', "{$user->name} was added as {$data['role']}.");
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate(['role' => 'required|in:admin,lecturer']);

        if ($user->is(auth()->user())) {
            return back()->with('error', 'You cannot change your own role.');
        }
        if ($user->hasRole('student')) {
            return back()->with('error', 'Student accounts are managed from the Students page.');
        }

        $user->syncRoles($data['role']);

        return back()->with('success', "{$user->name} is now a {$data['role']}.");
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user()) || $user->hasRole('student')) {
            return back()->with('error', 'This account cannot be deleted here.');
        }

        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}
