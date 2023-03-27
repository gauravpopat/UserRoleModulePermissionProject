<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function show()
    {
        $user = User::find(auth()->user()->id)->load('roles');
        return ok('User',$user);
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();

        return ok('User deleted successfully.');
    }
}
