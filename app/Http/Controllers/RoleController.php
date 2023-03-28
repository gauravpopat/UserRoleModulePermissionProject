<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //List of roles
    public function list()
    {
        $roles = Role::all()->load('permissions','users');
        return ok('Roles', $roles);
    }

    //Create role
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'              => 'required|unique:roles,name',
            'description'       => 'required',
            'permission_id'     => 'required|array|distinct|exists:permissions,id'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'Validation');

        $role = Role::create($request->only(['name', 'description']));

        //Give permission to the role.
        $role->permissions()->attach($request->permission_id);

        return ok('Role Created Successfully', $role);
    }

    //Update role
    public function update($id, Request $request)
    {
        $role = Role::find($id);

        $validation = Validator::make($request->all(), [
            'name'          => 'required|unique:roles,name,' . $role->id,
            'description'   => 'required',
            'permission_id' => 'required|array|distinct|exists:permissions,id'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'Validation');

        $role->update($request->only(['name','description']));

        $role->permissions->sync($request->permission_id);
    
        return ok('Role Updated Successfully');
    }

    //Delete role
    public function delete($id)
    {
        $role = Role::find($id);
        $role->permissions->detach();
        $role->delete();
        return ok('Role Deleted Successfully.');
    }

    //Show particular role
    public function show($id)
    {
        $role = Role::find($id);
        return ok('Role detail', $role);
    }
}
