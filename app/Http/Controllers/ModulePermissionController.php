<?php

namespace App\Http\Controllers;

use App\Models\ModulePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModulePermissionController extends Controller
{
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'permission_id'     => 'required|exists:permissions,id',
            'module_id'         => 'required|exists:modules,id',
            'view_access'       => 'required|in:1,0',
            'create_access'     => 'required|in:1,0',
            'update_access'     => 'required|in:1,0',
            'delete_access'     => 'required|in:1,0',
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        ModulePermission::create($request->all());
        return ok('Module Permissions Added');
    }

    public function update($id, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'view_access'   =>  'required|in:1,0',
            'create_access' =>  'required|in:1,0',
            'update_access' =>  'required|in:1,0',
            'delete_access' =>  'required|in:1,0'
        ]);
        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        ModulePermission::find($id)->update($request->all());
        return ok('Module Permission Updated Successfully');
    }

    public function show($id)
    {
        $modulePermission = ModulePermission::find($id);
        return ok('Module Permisssion',$modulePermission);
    }

    public function delete($id)
    {
        ModulePermission::find($id)->delete();
        return ok('Module Permission Deleted');
    }
}
