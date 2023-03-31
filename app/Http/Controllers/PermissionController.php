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
        $this->ListingValidation();
        $query = Permission::query();
        $searchable_fields = ['name'];
        $data = $this->filterSearchPagination($query, $searchable_fields);
        return ok('User Data', [
            'users' => $data['query']->get(),
            'count' => $data['count']
        ]);
    }

    //Create permission
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required|max:50|unique:permissions,name',
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
        $permission = Permission::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name'          => 'required|max:50|unique:permissions,name,' . $permission->id,
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
        $permission = Permission::findOrFail($id);

        $permission->roles()->detach();
        $permission->modules()->detach();

        $permission->delete();
        return ok('Permission Deleted Successfully');
    }

    //Show particular permission
    public function show($id)
    {
        $permission = Permission::findOrFail($id)->load('roles','modules');
        return ok('Permission detail', $permission);
    }
}
