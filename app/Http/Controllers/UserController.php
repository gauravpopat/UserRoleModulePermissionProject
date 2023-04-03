<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
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
        $user = User::findOrFail(auth()->user()->id)->load('roles', 'permissions');
        return ok('User', $user);
    }

    //Logout the user
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete(); //delete the token
        return ok('You have been logout.');
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
