<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    //permission list
    public function list()
    {
        $permissions = Permission::all()->load('roles', 'modules');
        return ok('Permissions', $permissions);
    }

    //Create permission
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required|unique:permissions,name',
            'description'   => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $permission = Permission::create($request->only(['name', 'description']));

        return ok('Permission Added', $permission);
    }

    //Update permission by ID
    public function update($id, Request $request)
    {
        $permission = Permission::find($id);

        $validation = Validator::make($request->all(), [
            'name'          => 'required|unique:permissions,name,' . $permission->id,
            'description'   => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $permission->update($request->all());

        return ok('Permission Updated Successfully');
    }

    //Delete permission by ID
    public function delete($id)
    {
        $permission = Permission::find($id);

        $permission->roles()->detach();
        $permission->modules()->detach();

        $permission->delete();
        return ok('Permission Deleted Successfully');
    }

    //Show particular permission
    public function show($id)
    {
        $permission = Permission::find($id);
        return ok('Permission detail', $permission);
    }
}
