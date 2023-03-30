<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //User with roles
    public function list()
    {
        $user = User::findOrFail(auth()->user()->id)->load('roles', 'permissions');
        return ok('User', $user);
    }

    //Update the user role
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'role' => 'required|array|exists:roles,id'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $user = User::findOrFail(auth()->user()->id);
        $user->roles()->sync($request->role);
        return ok('Role Updated Successfully');
    }

    //Show only user detail
    public function show()
    {
        $user = User::findOrFail(auth()->user()->id);
        return ok('User', $user);
    }

    //Delete the user with roles
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();

        return ok('User deleted successfully.');
    }
}
