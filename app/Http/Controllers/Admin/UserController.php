<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['role'] = 'user';

        $insert = User::create($data);

        if ($insert) {
            return redirect()->route('admin.users.index')->with('message', [
                'success' => true,
                'message' => 'User created successfully'
            ]);
        } else {
            return redirect()->route('admin.users.index')->with('message', [
                'success' => false,
                'message' => 'User failed to create'
            ]);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = $request->all();
        $user = User::find($id);
        //check if password is not empty
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            //if password is empty then use the old password
            $data['password'] = $user->password;
        }

        $update = $user->update($data);

        if ($update) {
            return redirect()->route('admin.users.index')->with('message', [
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } else {
            return redirect()->route('admin.users.index')->with('message', [
                'success' => false,
                'message' => 'User failed to update'
            ]);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $delete = $user->delete();

        if ($delete) {
            return redirect()->route('admin.users.index')->with('message', [
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } else {
            return redirect()->route('admin.users.index')->with('message', [
                'success' => false,
                'message' => 'User failed to delete'
            ]);
        }

    }
}
