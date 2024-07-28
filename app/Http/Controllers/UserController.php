<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('Delete User'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('Edit User'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('Add User'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('View User'), only: ['index', 'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('user.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'array',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user = User::where('email', $request->email)->first();

        // Default role 'User' if no roles provided
        $roles = $request->input('roles', ['User']);

        // Assign roles to the user using syncRoles
        $user->syncRoles($roles);

        flash()->success('User created successfully!');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //edit
        $user = User::find($id);
        if (!$user) {
            flash()->error('User not found!');
            return redirect()->route('users.index');
        }
        if ($user->hasRole('Super-Admin')) {
            flash()->error("You do not have permission to edit a super admin!");
            return redirect()->route('users.index');
        }
        $roles = Role::all();
        $allRoles = $user->roles->pluck('id')->toArray();
        return view('user.edit', compact('user', 'roles', 'allRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //update
        $user = User::find($id);
        if ($user->hasRole('Super-Admin')) {
            flash()->error("You do not have permission to edit a super admin!");
            return redirect()->route('users.index');
        }
        $user->name = $request->name;
        $user->email = $user->email;
        $user->password =  Hash::make($request->password);
        $user->save();
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        flash()->success('User updated successfully!');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete
        $user = User::find($id);
        // Check if the logged-in user is trying to delete themselves
        if ($user->id === auth()->user()->id) {
            flash()->error("You cannot delete your own account!");
            return redirect()->route('users.index');
        }

        // Check if the logged-in user is an admin and trying to delete a 'super-admin'
        if ($user->hasRole('Super-Admin')) {
            flash()->error("You do not have permission to delete a super admin!");
            return redirect()->route('users.index');
        }
        $user->delete();
        flash()->error('User deleted successfully!');
        return redirect()->route('users.index');
    }
}
