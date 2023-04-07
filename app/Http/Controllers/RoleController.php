<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ListingApiTrait;

class RoleController extends Controller
{
    use ListingApiTrait;
    //List of roles
    public function list()
    {
        $this->ListingValidation();
        $query = Role::query();
        $searchable_fields = ['name'];
        $data = $this->filterSearchPagination($query, $searchable_fields);
        return ok('User Data', [
            'roles' => $data['query']->get(),
            'count' => $data['count']
        ]);
    }

    //Create role
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'              => 'required|max:50|unique:roles,name',
            'description'       => 'required',
            'permission_id'     => 'required|array|distinct|exists:permissions,id'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $role = Role::create($request->only(['name', 'description']));

        //Give permission to the role.
        $role->permissions()->attach($request->permission_id);

        return ok('Role Created Successfully', $role);
    }

    //Update role
    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name'          => 'required|max:50|unique:roles,name,' . $role->id,
            'description'   => 'required',
            'permission_id' => 'required|array|distinct|exists:permissions,id'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $role->update($request->only(['name', 'description']));

        $role->permissions->sync($request->permission_id);

        return ok('Role Updated Successfully');
    }

    //Delete role
    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->permissions->detach();
        $role->delete();
        return ok('Role Deleted Successfully.');
    }

    //Show particular role
    public function show($id)
    {
        $role = Role::findOrFail($id)->load('permissions');
        return ok('Role detail', $role);
    }
}
