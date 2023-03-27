<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    //Module list
    public function list()
    {
        $modules = Module::all()->load('permissions');
        return ok('Modules with permissions', $modules);
    }

    //Create module
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required|unique:modules,name',
            'description'   => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'Validation');

        $module = Module::create($request->only(['name', 'description']));
        return ok('Module Added', $module);
    }

    //Update module by ID
    public function update($id, Request $request)
    {
        $module = Module::find($id);

        $validation = Validator::make($request->all(), [
            'name'          => 'required|unique:modules,name,' . $module->id,
            'description'   => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'Validation');

        $module->update($request->all());

        return ok('Module Updated Successfully');
    }

    //Delete module by ID
    public function delete($id)
    {
        $module = Module::find($id);

        $module->permissions()->detach();
        
        $module->delete();
        return ok('Module Deleted Successfully');
    }

    //Show particular module
    public function show($id)
    {
        $module = Module::find($id);
        return ok('Module detail', $module);
    }
}
